<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Model_Review_Comment
 *
 * @property int           id
 * @property string        text
 * @property string        added
 * @property string        updated
 * @property Model_Review  review
 * @property int           review_id
 * @property Model_User    user
 * @property int           user_id
 * @property Model_Company company
 * @property int           company_id
 */
class Model_Review_Comment extends ORM {

  protected $_belongs_to = [
    'review'  => [
      'model'       => 'Review',
      'foreign_key' => 'for_id',
    ],
    'user'    => [
      'model'       => 'User',
      'foreign_key' => 'user_id',
    ],
    'company' => [
      'model'       => 'Company',
      'foreign_key' => 'company_id',
    ],
  ];

  public function create(Validation $validation = null) {
    $now = date("Y-m-d H:i:s");
    $this->added = $now;
    $this->updated = $now;
    return parent::create($validation);
  }

  public function update(Validation $validation = null) {
    $this->updated = date("Y-m-d H:i:s");
    return parent::update($validation);
  }

  public function filters() {
    return [
      'text' => [
        ['trim'],
      ],
    ];
  }

  public function rules() {
    return [
      'text' => [
        ['not_empty'],
      ],
    ];
  }

}