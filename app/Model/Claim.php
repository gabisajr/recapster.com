<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Model_Claim жалоба
 *
 * @property int        $id
 * @property string     $date
 * @property string     $message - текст жалобы
 * @property string     $type    - тип жалобы: review, interview, salary, job, interview_job
 * @property int        $for_id  - id объекта на который пожаловались
 *
 * ----------------------- virtual --------------------------
 * @property string     $title   - заголовок жалобы
 * @property ORM        $object  - объект на который пожаловались
 *
 * ----------------------- belongs to -----------------------
 * @property Model_User $user    - пользователь добавивший отзыв
 * @property int        $user_id
 */
class Model_Claim extends ORM {

  protected $_belongs_to = [
    'user' => [
      'model'       => 'User',
      'foreign_key' => 'user_id',
    ],
  ];

  public function filters() {
    return [
      'message' => [
        ['trim'],
      ],
    ];
  }

  public function get($column) {

    switch ($column) {
      case 'title':
        return $this->get_title();
        break;
      case 'object':
        return $this->get_for_object();
        break;
    }

    return parent::get($column);
  }

  /**
   * @return ORM
   */
  public function get_for_object() {

    $for_object = null;

    switch ($this->type) {
      case SurveyType::REVIEW:
        $for_object = ORM::factory('Review', $this->for_id);
        break;

      case SurveyType::INTERVIEW:
        $for_object = ORM::factory('Interview', $this->for_id);
        break;

      case 'interview_question':
        $for_object = ORM::factory('Interview_Question', $this->for_id);
        break;

      case 'interview_answer':
        $for_object = ORM::factory('Interview_Answer', $this->for_id);
        break;

      case 'job':
        $for_object = ORM::factory('Job', $this->for_id);
        break;

      case 'image':
        $for_object = ORM::factory('Image', $this->for_id);
        break;

      case 'image_activity':
        $for_object = ORM::factory('Activity', ['id' => $this->for_id, 'type' => 'image']);
        break;
    }

    return $for_object;

  }

  public function get_title() {
    $title = null;

    $object = $this->get_for_object();

    switch ($this->type) {
      case 'review':
        $title = __('Жалоба на отзыв для компани :for_company', [
          ':for_company' => $object->company->title,
        ]);
        break;

      case 'interview':
        $title = __('Жалоба на собеседование :of_position в компанию :company', [
          ':of_position' => I18n::$lang == 'ru' ? Morpher::inflect($object->position->title, 'Р') : __($object->position->title),
          ':company'     => $object->company->title,
        ]);
        break;

      case 'interview_question':
        $title = __('Жалоба к вопросу на собеседование :of_position в компанию :company', [
          ':of_position' => I18n::$lang == 'ru' ? Morpher::inflect($object->interview->position->title, 'Р') : __($object->interview->position->title),
          ':company'     => $object->interview->company->title,
        ]);
        break;
    }

    return $title;
  }

  public function admin_url() {
    if (!$this->loaded()) return '#';
    return "http://$_SERVER[HTTP_HOST]/admin/claim/item/{$this->id}";
  }

}