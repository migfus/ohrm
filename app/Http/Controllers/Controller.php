<?php

namespace App\Http\Controllers;



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

  function resiseImage($max_width, $max_height, $source_file, $dst_dir, $quality = 80) {
    $imgsize = getimagesize($source_file);
    $width   = $imgsize[0]; // x
    $height  = $imgsize[1]; // y
    $mime    = $imgsize['mime']; // file extension

    switch($mime){
      case 'image/gif':
        $image_create = "imagecreatefromgif";
        $image = "imagegif";
        break;

      case 'image/png':
        $image_create = "imagecreatefrompng";
        $image = "imagepng";
        $quality = 7;
        break;

      case 'image/jpeg':
        $image_create = "imagecreatefromjpeg";
        $image = "imagejpeg";
        $quality = 80;
        break;
      default:
        return false;
        break;
    }

    $dst_img = imagecreatetruecolor($max_width, $max_height);
    $src_img = $image_create($source_file);

    $width_new = $height * $max_width / $max_height;
    $height_new = $width * $max_height / $max_width;
    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
    if($width_new > $width){
        //cut point by height
        $h_point = (($height - $height_new) / 2);
        //copy image
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
    }else{
        //cut point by width
        $w_point = (($width - $width_new) / 2);
        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
    }

    $image($dst_img, $dst_dir, $quality);

    if($dst_img) imagedestroy($dst_img);
    if($src_img) imagedestroy($src_img);
  }

  function userActivityUpdate($user_id) {

  }
}
