<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Model_Interview_Answer - ответ на вопрос собеседоания
 *
 * @property int                      id
 * @property string                   text   - текст ответа
 * @property string                   added  - дата добавления
 * @property int                      rating - рейтинг ответа
 * @property string                   name   - аннонимное имя отвечающего
 *
 * @property Model_Interview_Question question
 * @property int                      question_id
 *
 * @property Model_User               user
 * @property int                      user_id
 */
class Model_Interview_Answer extends ORM {

  protected $_belongs_to = [
    'question' => [
      'model'       => 'Interview_Question',
      'foreign_key' => 'question_id',
    ],
    'user'     => [
      'model'       => 'User',
      'foreign_key' => 'user_id',
    ],
  ];

  public function create(Validation $validation = NULL) {
    $this->added = date("Y-m-d H:i:s");
    return parent::create($validation);
  }


  public function filters() {
    return [
      'text' => [
        ['HTML::chars'],
      ],
    ];
  }

  public function vote_up(Model_user $user) {
    return $this->set_vote_flag($user, 'up');
  }

  public function vote_down(Model_user $user) {
    return $this->set_vote_flag($user, 'down');
  }

  public function get_vote($user) {

    if (!$user || !$user->loaded()) return false;

    //найти голос
    /** @var Countable $res */
    $res = DB::select()
      ->from('interview_answers_votes')
      ->where('answer_id', '=', $this->id)
      ->and_where('user_id', '=', $user->id)
      ->limit(1)
      ->as_object()
      ->execute();

    if (count($res)) return $res[0]->flag;

    return null;
  }

  private function set_vote_flag(Model_User $user, $flag) {

    if (!in_array($flag, ['up', 'down'])) return null;

    if ($vote = $this->get_vote($user)) {

      if ($vote != $flag) {
        return DB::update('interview_answers_votes')
          ->set(['flag' => $flag])
          ->where('answer_id', '=', $this->id)
          ->and_where('user_id', '=', $user->id)
          ->execute();
      } else {
        return null;
      }

    } else {

      return DB::insert('interview_answers_votes', ['answer_id', 'user_id', 'flag'])
        ->values([$this->id, $user->id, $flag])
        ->execute();
    }
  }

  public function recount_rating() {

    //count 'up' votes
    /** @var Countable $res_up_votes */
    $res_up_votes = DB::select()
      ->from('interview_answers_votes')
      ->where('answer_id', '=', $this->id)
      ->and_where('flag', '=', 'up')
      ->execute();

    $up_count = count($res_up_votes);

    //count 'down' votes
    /** @var Countable $res_down_votes */
    $res_down_votes = DB::select()
      ->from('interview_answers_votes')
      ->where('answer_id', '=', $this->id)
      ->and_where('flag', '=', 'down')
      ->execute();

    $down_count = count($res_down_votes);

    $rating = $up_count - $down_count;

    $this->rating = $rating;
    $this->update();

    return $rating;

  }
}