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
    $data = SystemSettingCategory::with('system_settings.system_setting_type')->orderBy('sort_id', 'ASC')->get();
    return Inertia::render('dashboard/SystemSettings/(Page)', ['pageTitle' => 'System Settings', 'data' => $data]);
  }

  public function update(Request $req, $id) : RedirectResponse {
    $val = $req->validate([
      'value' => ['required'],
      'type' => ['required']
    ]);

    // NOTE: for website logo
    if($req->type == 'avatar') {
      try {
        $avatar = $this->GUploadAvatar($req->value, 'system');
        SystemSettings::where('id', $id)->update(['value' => $avatar]);
      }
      catch(\Exception $error) {
        return to_route('dashboard.system-settings')->withErrors([
          'value' => 'Invalid Image! Please upload an image if you desire to change.',
        ]);
      }
    }
    // NOTE: other parameters
    else {
      SystemSettings::where('id', $id)->update(['value' => $req->value]);
    }

    return to_route('dashboard.system-settings');
  }
}
