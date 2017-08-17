<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;
use Session;

class ProfileController extends Controller {

  public function index(Request $request) {

    /** @var User $user */
    $user = $request->user;

    $showWelcome = $user->isMe() && Session::pull('show_user_welcome_modal');

    $experiences = $user->experiences()
      ->orderBy('is_current', 'DESC')
      ->orderBy('end_year', 'DESC')
      ->orderBy('end_month', 'DESC')
      ->orderBy('start_year', 'DESC')
      ->orderBy('start_month', 'DESC')
      ->get();

    $educations = $user->educations()
      ->orderBy('end_year', 'DESC')
      ->orderBy('start_year', 'DESC')
      ->get();

    $exams = $user->exams()
      ->orderBy('year', 'DESC')
      ->get();

    $userSkills = $user->skills()->get();
    $userLangs = $user->langs()->orderBy('level', 'DESC')->get();

    $subscriptions = $user->subscriptions()->latest()->get();

    $emptyProfile = !$user->about && !count($experiences) && !count($educations) && !count($exams) && !count($userSkills) && !count($userLangs);

    return view('user.page.profile', [
      'title'          => $user->fullname(),
      'user'           => $user,
      'jobPreferences' => $user->job_preferences,
      'showWelcome'    => $showWelcome,
      'experiences'    => $experiences,
      'educations'     => $educations,
      'userSkills'     => $userSkills,
      'userLangs'      => $userLangs,
      'exams'          => $exams,
      'subscriptions'  => $subscriptions,
      'emptyProfile'   => $emptyProfile,
    ]);

    //$this->styles[] = CSS::BOOTSTRAP_STAR_RATING;
    //$this->styles[] = CSS::BOOTSTRAP_STAR_RATING_KRAJEE_SVG;
  }
}