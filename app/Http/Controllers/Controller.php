<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

abstract class Controller
{
  public function gUploadAvatar($avatar, $path) {
    if (strpos($avatar, 'default')) {
      return $avatar;
    }
    list($type, $image) = explode(';', $avatar);
    list(, $image) = explode(',', $image);

    $image = base64_decode($image);
    $imageName = time(). '.jpg';
    $location = '/uploads/'.$path;

    if(!file_exists(public_path().$location)) {
      mkdir(public_path().$location, 0777, true);
    }
    file_put_contents(public_path().$location.'/'.$imageName, $image);

    return $location.'/'.$imageName;
  }
}
