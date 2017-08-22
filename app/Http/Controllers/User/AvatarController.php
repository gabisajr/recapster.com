<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Image;
use Auth;

class AvatarController extends Controller {

  public function upload(Request $request) {
    $user = Auth::user();
    $avatarFile = $request->file('avatar');
    $url = null;
    if ($avatarFile) {
      $path = $avatarFile->store('avatars', 'public');

      //create new image
      $avatar = new Image();
      $avatar->path = $path;
      $avatar->disk = "public";
      $avatar->save();

      //update user avatar
      if ($user->avatar) $user->avatar->delete();
      $user->avatar()->associate($avatar);
      $user->save();

      $url = $avatar->url();

    }
    return $url;
  }

}