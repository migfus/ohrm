<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use App\Events\PostsEvent;
use App\Models\PostContent;
use App\Models\PostType;
use Pawlox\VideoThumbnail\Facade\VideoThumbnail;

class ManagePostController extends Controller
{
  public function index(Request $req) {
    if($req->group_id) {
      return response()->json(
        Post::query()
          ->where('group_id', $req->group_id)
          ->with(['user', 'post_contents', 'post_type'])
          ->withCount(['post_contents'])
          ->orderBy('created_at', 'DESC')
          ->paginate(10)
      );
    }
  }

  public function store(Request $req) : JsonResponse {
    $req->validate([
      'type' => ['required'],
    ]);

    switch($req->type) {
      case 'basic':
        return $this->storeBasic($req);
      case 'multimedia':
        return $this->storeMultimedia($req);
      case 'documents':
        return $this->storeDocuments($req);
      default:
        return response()->json(['error' => 'Invalid post type'], 400);
    }
  }
    private function storeBasic($req) {
      $req->validate([
        'group_id' => ['required', 'uuid'],
        'title' => ['required','string'],
      ]);

      $post = Post::create([
        'user_id'  => $req->user()->id,
        'group_id' => $req->group_id,
        'post_type_id' => PostType::where('name', 'Basic')->first()->id,
        'title'  => $req->title,
      ]);

      PostsEvent::dispatch('new-post', $post->toArray());

      return response()->json(
        Post::query()
          ->where('id', $post->id)
          ->with(['user'])
          ->first()
      );
    }

    private function storeMultimedia($req) {
      $req->validate([
        'group_id' => ['required', 'uuid'],
        'title' => ['required','string'],
        'files' => ['required', 'array'],
        'files.*' => ['required', File::types(['jpg', 'png', 'jpeg', 'gif', 'mp4'])]
      ]);

      $files = $req->file('files');

      $post = Post::create([
        'user_id'  => $req->user()->id,
        'group_id' => $req->group_id,
        'post_type_id' => PostType::where('name', 'Multimedia')->first()->id,
        'title'  => $req->title,
      ]);


      if($req->hasFile('files')) {
        foreach($files as $file) {
          $link = Storage::disk('public')->putFile("groups/$req->group_id/uploads", $file);
          PostContent::create([
            'post_id' => $post->id,
            'data_type' => $file->getClientOriginalExtension(),
            'file_url' => Storage::url($link),
            'thumbnail_url' => Storage::url($link),
            'name' => $file->getClientOriginalName(),
          ]);
        }
      }

      return response()->json(['message' => 'Files uploaded successfully'], 200);
    }

    private function storeDocuments($req) {
      $req->validate([
        'group_id' => ['required', 'uuid'],
        'title' => ['required','string'],
        'files' => ['required', 'array'],
        'files.*' => ['required', File::types([
          // IMAGES
          'jpg',
          'png',
          'jpeg',
          'gif',

          // VIDEOS
          'mp4',

          // WORDS
          'doc',
          'docx',
          'pdf',
          'txt',

          // EXCEL
          'xlsx',
          'xls',
          'csv',

          // POWER POINT
          'ppt',
          'pptx',

          // ARCHIVES
          'zip',
          'rar',
        ])]
      ]);

      $files = $req->file('files');
      $root_path = "groups/$req->group_id/uploads";

      $post = Post::create([
        'user_id'  => $req->user()->id,
        'group_id' => $req->group_id,
        'post_type_id' => PostType::where('name', 'Documents')->first()->id,
        'title'  => $req->title,
      ]);


      if($req->hasFile('files')) {
        foreach($files as $file) {
          $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)."-".time().".".$file->getClientOriginalExtension();
          $link = Storage::disk('public')->putFileAs($root_path, $file, $file_name);

          PostContent::create([
            'post_id' => $post->id,
            'data_type' => $file->getClientOriginalExtension(),
            'file_url' => Storage::url($link),
            'thumbnail_url' => Storage::url($link),
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
          ]);
        }
      }

      return response()->json(['message' => 'Files uploaded successfully'], 200);
    }

  public function update(Request $req, string $id) : JsonResponse {
    $req->validate([
      'type' => ['required', 'string']
    ]);

    switch($req->type) {
      case 'pin':
        $this->pinPost($id); break;
      case 'update-content':
        $this->updateContent($req, $id); break;
    }

    $updated_post = Post::query()
      ->where('id', $id)
      ->with(['user'])
      ->first();

    return response()->json($updated_post);
  }
    private function pinPost(string $id) : void {
      $pin_toggle = Post::where('id', $id)->first()->is_pinned;

      Post::where('id', $id)->update([
        'is_pinned' => !$pin_toggle,
      ]);
    }
    private function updateContent(Request $req, string $id) : void {
      $req->validate([
        'content' => ['required'],
      ]);

      Post::where('id', $id)->update([
        'content' => json_encode($req->content),
      ]);
    }


  public function destroy(string $id) : JsonResponse {
    Post::where('id', $id)->delete();

    return response()->json(['success' => true]);
  }
}
