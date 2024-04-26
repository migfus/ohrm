<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

abstract class Controller
{
  public function GUploadAvatar($avatar, $path = 'system') {
    list($type, $image) = explode(';', $avatar);
    list(, $image) = explode(',', $image);

    $image = base64_decode($image);
    $imageName = time(). '.jpg';
    $location = '/uploads/'.$path.'/'.$imageName;
    file_put_contents('uploads/'.$path.'/'.$imageName, $image);

    return url('').$location;
  }
}
