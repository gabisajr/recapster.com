<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Model_Activity
 * @property int           $id
 * @property string        $type    - тип активности
 * @property string        $date    - дата создания активности
 * @property boolean       $anonym  - является ли активность анонимной
 * @property string        $status  - статус активности @see modules/enums/classes/Status.php
 * @property string        $text    - текст активности
 *
 * -------------------- virtual ---------------------------------------------
 * @property string        $url     - ссылка на страницу активности
 *
 * -------------------- belongs to ------------------------------------------
 *
 * @property Model_User    $user    - пользователь, чья активность
 * @property int           $user_id
 *
 * @property Model_Review  $review  - отзыв, если тип активности 'review'
 * @property int           $review_id
 *
 * @property Model_Company $company - компания для которой оставлена активность
 * @property int           $company_id
 *
 * -------------------- has many --------------------------------------------
 *
 * @property ORM           $images  - фотографии, если тип активности 'image'
 */
class Model_Activity extends ORM {

  protected $_table_name = 'activity';

  protected $_belongs_to = [
    'user'    => [
      'model'       => 'User',
      'foreign_key' => 'user_id',
    ],
    'review'  => [
      'model'       => 'Review',
      'foreign_key' => 'review_id',
    ],
    'company' => [
      'model'       => 'Company',
      'foreign_key' => 'company_id',
    ],
  ];

  protected $_has_many = [
    'images' => [
      'model'       => 'Image',
      'foreign_key' => 'activity_id',
      'far_key'     => 'img_id',
      'through'     => 'activity_images',
    ],
  ];

  public function filters() {
    return [
      'text' => [
        ['trim'],
      ],
    ];
  }

  public function rules() {
    return [
      'type' => [
        ['not_empty'],
        ['in_array', [':value', ['review', 'image']]],
      ],
    ];
  }

  public function get($column) {
    switch ($column) {
      case 'url':
        return '#'; //todo activity page on company profile
        break;
    }
    return parent::get($column);
  }

  /**
   * @param bool $cascade - использовать каскадное удаление
   * @return ORM
   * @throws Kohana_Exception
   */
  public function delete($cascade = true) {

    if ($cascade) {

      //delete images
      foreach ($this->images->find_all() as $img) $img->delete();
    }

    return parent::delete();
  }

  public function create_image_activity($user, $images, $company, $anonym = false, $text = null) {

    /** @var Model_Activity $activity */
    $activity = ORM::factory($this->object_name());
    $activity->type = 'image';
    $activity->user = $user;
    $activity->anonym = $anonym;
    $activity->text = $text;
    $activity->company = $company;
    $activity->save();
    foreach ($images as $image) $activity->add('images', $image);

    return $activity;
  }

  public function normalize() {
    if ($this->type == 'review') {
      $review = $this->review;
      if ($review->loaded()) {
        $this->date = $review->added;
        $this->user_id = $review->user_id;
        $this->anonym = $review->anonym;
        $this->company_id = $review->company_id;
        $this->status = $review->status;
        $this->save();
      } else {
        $this->delete();
      }
    } elseif ($this->type == 'image') {

      /** @var Model_Image[] $images */
      $images = $this->images->find_all();
      if (count($images)) {

        $status = Status::PENDING;
        foreach ($images as $image) {
          if ($image->status == Status::APPROVED) {
            $status = Status::APPROVED;
            break;
          }
        }
        $this->status = $status;
        $this->save();

      } else {
        $this->delete(false);
      }
    }
  }

}