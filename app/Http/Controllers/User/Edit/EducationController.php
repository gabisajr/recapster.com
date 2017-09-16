<?php

namespace App\Http\Controllers\User\Edit;

use App\Http\Controllers\Controller;
use App\Model\University;
use App\Model\UserEducation;
use Auth;
use Illuminate\Http\Request;

class EducationController extends Controller {

  public function showForm() {
    $user = Auth::getUser();
    $educations = $user->educations()->get();

    return view('user.edit.education', [
      'title'          => __('My education'),
      'user'           => $user,
      'educations'     => $educations,
      'editMenuActive' => 'education',
    ]);
  }

  public function store(Request $request) {

    $arrEducation = $request->input('education', []);
    $arrId = array_get($arrEducation, 'id', []);
    $arrUniversityId = array_get($arrEducation, 'university', []);
    $arrFacultyId = array_get($arrEducation, 'faculty', []);
    $arrChairId = array_get($arrEducation, 'chair', []);
    $arrEduForm = array_get($arrEducation, 'educationForm', []);
    $arrEduStatus = array_get($arrEducation, 'educationStatus', []);
    $arrStartYear = array_get($arrEducation, 'startYear', []);
    $arrEndYear = array_get($arrEducation, 'endYear', []);
    $arrText = array_get($arrEducation, 'text', []);

    foreach ($arrId as $key => $id) {

      /** @var UserEducation $education */
      $education = UserEducation::query()
        ->where('id', '=', $id)
        ->where('user_id', '=', Auth::getUser()->id)
        ->first();

      //set university for new education object
      if (!$education) {
        $education = new UserEducation();
        /** @var University $university */
        $university = University::find(array_get($arrUniversityId, $key));
        if (!$university) continue; //not save education for unknown university
        $education->university_id = $university->id;
        $education->user_id = Auth::getUser()->id;
      }

      $education->start_year = array_get($arrStartYear, $key);
      $education->end_year = array_get($arrEndYear, $key);
      $education->faculty_id = array_get($arrFacultyId, $key);
      $education->chair_id = array_get($arrChairId, $key);
      $education->edu_form_id = array_get($arrEduForm, $key);
      $education->status_id = array_get($arrEduStatus, $key);
      $education->text = array_get($arrText, $key);
      $education->save();

    }

    return ['success' => true];

  }

  public function delete(Request $request) {
    $educationId = $request->input('id');
    $userId = Auth::getUser()->id;
    $education = UserEducation::where(['id' => $educationId, 'user_id' => $userId])->first();
    if ($education) $education->delete();
  }

}