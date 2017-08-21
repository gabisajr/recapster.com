<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Activity extends Controller_User_Base {

  public function action_index() {

    $user = $this->user;

    $search = new Search_Engine_Activity($this->curr_user);
    $activities = $search->set_user_id($user->id)->find()->get_results();
    $activities_count = $search->get_found_count();

    $activities = (new Search_Results_Activities($activities, 0, 'activity-list'))->__toString();

    $view = View::factory('user/page/activity', [
      'user'             => $user,
      'activities_count' => $activities_count,
      'activities'       => $activities,
    ]);

    $layout = View::factory('user/layout', [
      'content' => $view,
    ]);

    $this->template->title = $this->is_me ? __('Моя активность') : __('Активность :of_fullname', [':of_fullname' => $user->of_fullname]);
    $this->template->content = $layout;
    $this->main_js = '/js/user/activity.js';
    $this->styles[] = CSS::BOOTSTRAP_STAR_RATING;
    $this->styles[] = CSS::BOOTSTRAP_STAR_RATING_KRAJEE_SVG;
    $this->styles[] = CSS::AWESOME_BOOTSTRAP_CHECKBOX;

  }

}