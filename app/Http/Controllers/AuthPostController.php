<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;

use App\Models\Post;
use App\Events\PostsEvent;
use App\Models\PostContent;
use App\Models\PostType;
use App\Models\Group;

class AuthPostController extends Controller
{
  public function index(Request $req) : JsonResponse {
    $group_ids = Group::query()
      ->whereHas('group_members', function($q) {
        $q->where('user_id', auth()->user()->id);
      })
      ->get()
      ->map(fn($row) => [$row->id])
      ->toArray();

    return response()->json(
      Post::query()
        ->whereIn('group_id', $group_ids)
        ->with([
          'user',
          'group',
          'post_contents',
          'post_type',
          'reaction_users' => function($q) {
            $q->select('reaction_id', DB::raw('count(*) as total'), 'reactable_type', 'reactable_id')
              ->groupBy(['reaction_id', 'reactable_type', 'reactable_id'])
              ->with('reaction');
          },
          'auth_reaction' => function($q) use ($req) {
            $q->where('user_id', $req->user()->id);
          },
          'comments' => function($q) use($group_ids){
            $q->with(['user.group_members' => function($qu) use($group_ids) {
              $qu->whereIn('group_id', $group_ids)->with('role');
            }])
              ->orderBy('created_at', 'DESC')->limit(3);
          }
        ])
        ->withCount(['comments', 'post_contents'])
        ->orderBy('created_at', 'desc')
        ->paginate(10)
    );
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
    private function storeBasic($req) : JsonResponse {
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

      dd($post);

      PostsEvent::dispatch('new-post', $post->toArray());

      return response()->json(
        Post::query()
          ->where('id', $post->id)
          ->with(['user'])
          ->first()
      );
    }
    private function storeMultimedia($req) : JsonResponse {
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
    private function storeDocuments($req) : JsonResponse {
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
      case 'title':
        $this->updateTitle($req, $id); break;
    }

    return response()->json(['success' => true]);
  }
    private function pinPost(string $id) : void {
      $pin_toggle = Post::where('id', $id)->first()->is_pinned;

      Post::where('id', $id)->update([
        'is_pinned' => !$pin_toggle,
      ]);
    }
    private function updateTitle(Request $req, string $id) : void {
      $req->validate([
        'title' => ['required'],
      ]);

      Post::where('id', $id)->update([
        'title' => $req->title,
      ]);
    }


  public function destroy(string $id) : JsonResponse {
    Post::where('id', $id)->delete();
    return response()->json(['success' => true]);
  }
}
