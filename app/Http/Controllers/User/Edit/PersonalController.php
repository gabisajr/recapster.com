<?php

namespace App\Http\Controllers\User\Edit;

use App\Http\Controllers\Controller;
use App\Model\Country;
use App\Model\User;
use App\Regex;
use App\UserJobStatus;
use Illuminate\Support\Collection;
use Auth;
use Illuminate\Http\Request;

class PersonalController extends Controller {

  public function showForm() {

    /** @var User $user */
    $user = Auth::user();
    $countries = Country::get();


    if ($user && $user->country) {
      $cities = $user->country->cities()->orderBy('title')->get();
    } else {
      $cities = new Collection([]);
    }

    return view('user.edit.personal', [
      'title'          => __('Редактирование личной информации'),
      'user'           => $user,
      'countries'      => $countries,
      'cities'         => $cities,
      'statuses'       => UserJobStatus::getStatuses(),
      'editMenuActive' => 'personal',
    ]);
  }

  public function store(Request $request) {

    $usernameRegex = Regex::USERNAME;

    $user = Auth::getUser();

    $this->validate($request, [
      'firstname' => "required",
      'lastname'  => "required",
      'username'  => "required|max:30|regex:$usernameRegex|unique:users,username,$user->id",
    ]);

    $user->firstname = $request->input('firstname');
    $user->lastname = $request->input('lastname');
    //$user->patronymic = $request->input('patronymic');
    $user->username = $request->input('username');
    $user->position_title = $request->input('position');
    $user->job_status = $request->input('job_status');
    $user->sex = $request->input('sex');
    $user->birth_day = $request->input('birth_day');
    $user->birth_month = $request->input('birth_month');
    $user->birth_year = $request->input('birth_year');
    $user->country_id = $request->input('country');
    $user->city_id = $request->input('city');
    $user->about = $request->input('about');
    $user->save();
    //$user->save_upload_avatar();

    return redirect(route('user.edit.personal'))->with('success', true);
  }

}