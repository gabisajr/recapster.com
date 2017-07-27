<?php

namespace App\Http\Controllers\Admin;

use App\Model\Image;
use Illuminate\Http\Request;

class ImageController extends AdminController {

  protected $object_name = 'Image';
  protected $sort_field = 'added';
  protected $sort_direction = 'DESC';

  //list of company photos
  public function action_list() { //todo

    /** @var Model_Company $company */
    $company = ORM::factory('Company', Arr::get($_GET, 'company'));
    if (!$company->loaded()) {
      session(['message_error' => __('Компания не найдена')]);
      HTTP::redirect("/admin/company/list");
    }

    //update images status
    if ($this->request->method() == Request::POST) {

      $statuses = Arr::get($_POST, 'status', []);
      $approved_images_groups = [];

      foreach ($statuses as $image_id => $status) {
        /** @var Model_Image $image */
        $image = ORM::factory('Image', $image_id);
        if ($image->loaded()) {
          $old_status = $image->status;
          $image->status = $status;
          $image->save();

          //запоминаем одобренные фотографии, сгрупировано по пользователям
          if ($image->status != $old_status && $image->status == Status::APPROVED) {
            $approved_images_groups[$image->user_id][] = $image;
          }

        }
      }

      $company->recount_images();

      //уведомляем пользователей о том что их фотографии одобрены
      foreach ($approved_images_groups as $user_id => $approved_images) {
        /** @var Model_User $user */
        $user = ORM::factory('User', $user_id);
        if ($user->email && $user->confirmed) {
          if (count($approved_images) > 1) {
            $subject = __('Ваши фотографии опубликованы на :app_name', [':app_name' => $this->app_name]);
          } else {
            $subject = __('Ваша фотография опубликована на :app_name', [':app_name' => $this->app_name]);
          }

          $app_name = $this->app_name;

          //if user is employer
          if ($user->has('companies', $company)) {
            $email_html = View::factory('email/approved-photos-employer', [
              'app_name' => $app_name,
              'company'  => $company,
              'user'     => $user,
              'images'   => $approved_images])->render();
          } else {
            $email_html = View::factory('email/approved-photos', [
              'app_name' => $app_name,
              'company'  => $company,
              'images'   => $approved_images])->render();
          }

          Email::instance()->send($user->email, $subject, $email_html);
        }
      }

      if (count($statuses)) {
        session(['message_success' => __('Статусы обновлены')]);
      }
      HTTP::redirect("/admin/$this->lower_object_name/list?company=$company->id");
    }

    $page = Arr::get($_GET, 'page', 1);
    $offset = ($page - 1) * $this->item_per_page;

    $images = $company->images
      ->limit($this->item_per_page)
      ->offset($offset)
      ->order_by('added', 'DESC')
      ->find_all();

    $total = $company->images->count_all();

    $view = View::factory("admin/$this->lower_object_name/list");
    $view->set([
      'company'    => $company,
      'images'     => $images,
      'total'      => $total,
      'pagination' => $this->get_pagination($total),
    ]);

    $this->template->content = $view;
  }

  //edit image title
  public function action_item() {

    $back_url = Session::instance()->get('image_edit_back_url');
    $errors = [];

    /** @var Model_Image $image */
    $image = ORM::factory('Image', $this->request->param('id'));
    if (!$image->loaded()) {
      Session::instance()->set('message_error', __('Изображение не найдено'));
      HTTP::redirect($back_url);
    }

    if ($this->request->method() == Request::POST) {

      $old_status = $image->status;

      $image->title = Arr::get($_POST, 'title');
      $image->status = Arr::get($_POST, 'status', Status::PENDING);
      $image->anonym = (boolean)Arr::get($_POST, 'anonym');

      $validation = $image->validation();

      //проверка чтобы компания была активирована
      $validation->rule('company', function (Model_Image $image, Validation $validation, $field) {
        /** @var Model_Company $company */
        $company = $image->companies->find();
        if ($company->loaded() && !$company->active) $validation->error($field, 'not_active');
      }, [$image, ':validation', ':field']);


      if ($validation->check()) {
        $image->save();


        if ($image->status != $old_status) {

          //сменить статус активности
          $activity = $image->get_activity();
          if ($activity->loaded()) {
            $activity_approved_images_count = $activity->images->where('image.status', '=', Status::APPROVED)->count_all();
            if ($activity_approved_images_count) {
              $activity->status = Status::APPROVED;
            } else {
              $activity->status = Status::PENDING;
            }
            $activity->save();
          }

          //пересчитать кол-во фоток у компании
          if ($image->company->loaded()) $image->company->recount_images();

          //уведомить пользователя о том что его фотография одобрена
          if ($image->status == Status::APPROVED) $image->notify_user_approved();
        }

        Session::instance()->set('message_success', __('Информация успешно сохранена'));
        HTTP::redirect($back_url);
      } else {
        $errors = $validation->errors('models/image');
      }

    } else {
      Session::instance()->set('image_edit_back_url', Arr::get($_SERVER, 'HTTP_REFERER', "/admin/{$this->lower_object_name}/list"));
    }

    $view = View::factory("/admin/{$this->lower_object_name}/item", [
      'image'  => $image,
      'errors' => $errors,
    ]);

    $this->title = __('Фото :id', [':id' => $image->id]);
    $this->template->content = $view;
  }

  //delete image
  public function delete(Request $request) {
    $success = false;


    $id = $request->input('id');
    if ($id) {
      /** @var Model_Image $image */
      $image = Image::find($id);
      if ($image) {

        //$company = $image->company;

        $image->delete();
        $success = true;

        //if ($company->loaded()) $company->recount_images(); //todo recount company images

      }
    }

    if ($request->ajax()) return ['success' => $success];


    session(['message_success' => __('Фото успешно удалено')]);
    return back();

  }

}