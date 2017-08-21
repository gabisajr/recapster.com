<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Model\Company;
use Illuminate\Http\Request;

class ProfileController extends Controller {

  public function index(Request $request) {

    /** @var Company $company */
    $company = $request->company;

    $review = null;

    ////пробуем найти отзыв текущего пользователя //todo render current user review
    //if ($this->curr_user) {
    //  $search = new Search_Engine_Reviews($this->curr_user);
    //  $review = $search->set_company($this->company)
    //    ->set_limit(1)
    //    ->set_user_id($this->curr_user->id)
    //    ->find()
    //    ->get_result();
    //}
    //
    ////пробуем найти самый полезный отзыв
    //if (!$review) {
    //  $search = new Search_Engine_Reviews($this->curr_user);
    //  $review = $search
    //    ->set_company($this->company)
    //    ->set_limit(1)
    //    ->set_sort('popular')
    //    ->find()
    //    ->get_result();
    //}
    //
    //if ($review) $review = (new Post_Review($review))->__toString();
    //
    //$has_my_review = $this->company->has_user_review($this->curr_user);
    //
    //$page = View::factory('company/page/profile', [
    //  'company'       => $this->company,
    //  'review'        => $review,
    //  'has_my_review' => $has_my_review,
    //]);
    //
    //$layout = new Layout_Company($this->company, $page);
    //
    //$this->template->content = $layout;
    //$this->main_js = '/js/company/profile.js'; //todo add url
    //$this->styles[] = CSS::AWESOME_BOOTSTRAP_CHECKBOX;

    return view('company.page.profile', [
      'title'   => $company->title,
      'company' => $company,
      'review'  => $review,
    ]);
  }

}