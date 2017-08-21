<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Model_Job_Application
 *
 * Заявка на вакансию
 *
 * @property int        id
 * @property string     firstname
 * @property string     tel
 * @property string     email
 * @property string     city_title       - в каком городе проживает заявитель
 * @property string     message          - сопроводительно сообщение к заявке
 * @property string     message_response - ответ работодателя
 * @property boolean    response_read    - прочитал ли заявитель ответ работодателя
 * @property string     added            - дата добавления
 * @property string     answered         - дата ответа работодателя
 * @property string     status           - статуст заявки (ожидает, просмотрена, отказ, приглашение)
 * @property boolean    is_archive       - заявка в архиве
 *
 * ------- belongs to -----------
 * @property Model_User user             - заявитель
 * @property int        user_id
 *
 * @property Model_Job  job              - вакансия на которую оформляется заявка
 * @property int        job_id
 *
 * @property Model_File file             - файл прикрепленный к заявке
 * @property int        file_id
 */
class Model_Job_Application extends ORM {

  protected $_belongs_to = [
    'user' => [
      'model'       => 'User',
      'foreign_key' => 'user_id',
    ],
    'job'  => [
      'model'       => 'Job',
      'foreign_key' => 'job_id',
    ],
    'file' => [
      'model'       => 'File',
      'foreign_key' => 'file_id',
    ],
  ];

  public function filters() {
    return [
      true => [
        ['trim'],
      ],
    ];
  }

  public function rules() {
    return [
      'firstname' => [
        ['not_empty'],
      ],
      'tel'       => [
        ['not_empty'],
      ],
      'email'     => [
        ['not_empty'],
        ['email'],
      ],
      'message'   => [
        ['not_empty'],
      ],
      'job_id'    => [

        //check job exists and available for apply
        [function ($job_id, $field, Validation $validation) {
          $job = ORM::factory('Job')->where('id', '=', $job_id)->and_where('status', '=', Status::APPROVED)->find();
          if (!$job->loaded()) $validation->error($field, 'not_found');
        }, [':value', ':field', ':validation']],
      ],
    ];
  }

  public function create(Validation $validation = null) {
    $this->added = date("Y-m-d H:i:s");
    return parent::create($validation);
  }

  public function delete() {

    if ($this->file->loaded()) $this->file->delete();

    return parent::delete();
  }

}