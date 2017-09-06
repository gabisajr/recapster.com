<?php

namespace App\Http\Controllers\User\Edit;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class ContactsController extends Controller {

  public function showForm() {

    return view('user.edit.contacts', [
      'title'          => __('Редактирование контактов'),
      'user'           => Auth::user(),
      'editMenuActive' => 'contacts',
    ]);
  }

  public function store(Request $request) {

    $user = Auth::getUser();

    $user->skype = $request->input('skype');
    $user->instagram = $request->input('instagram');
    $user->twitter = $request->input('twitter');
    $user->site = $request->input('site');
    $user->save();

    return redirect(route('user.edit.contacts'))->with('success', true);

  }

}