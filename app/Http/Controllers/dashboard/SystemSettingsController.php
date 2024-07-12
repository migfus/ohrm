<?php
namespace App\Http\Controllers\dashboard;

use App\Models\SystemSettingCategory;
use App\Models\SystemSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SystemSettingsController extends Controller
{
  public function index() : Response {
    $data = SystemSettingCategory::query()
      ->with('system_settings.system_setting_type')
      ->orderBy('sort_id', 'ASC')
      ->get();
    return Inertia::render('dashboard/system-settings/(Index)', [
      'page_title' => 'System Settings',
      'data' => $data
    ]);
  }

  public function update(Request $req, $id) : RedirectResponse {
    $req->validate([
      'value' => ['required'],
      'type'  => ['required']
    ]);

    // NOTE: for website logo
    if($req->type == 'avatar') {
      try {
        $avatar = $this->gUploadAvatar($req->value, 'system');
        SystemSettings::query()
          ->where('id', $id)
          ->update(['value' => $avatar]);
      }
      catch(\Exception $error) {
        return to_route('dashboard.system-settings')
          ->withErrors(['value' => 'Invalid Image! Please upload an image if you desire to change.']);
      }
    }
    // NOTE: other parameters
    else
      SystemSettings::where('id', $id)->update(['value' => $req->value]);

    return to_route('dashboard.system-settings.index')
      ->with('success', ['title' => 'Updated Successfully!','message' => 'Your changes have been saved.']);
  }
}
