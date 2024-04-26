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

  public function submit(Request $req) : RedirectResponse {
    $val = $req->validate([
      'id' => ['required'],
      'value' => ['required']
    ]);

    SystemSettings::where('id', $req->id)->update(['value' => $req->value]);

    return to_route('dashboard.system-settings');
  }
}
