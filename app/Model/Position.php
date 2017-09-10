<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Position
 *
 * @property int $id
 * @property string $title
 * @property string $slug альяс для ссылки
 * @property int $salaries_count количество одобренных зарплат
 * @property int $reviews_count количество одобренных отзывов
 * @property int $interviews_count количество одобренных собеседований
 * @property int $jobs_count количество активных вакансий
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Interview[] $interviews
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Job[] $jobs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Review[] $reviews
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Salary[] $salaries
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Position search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Position whereInterviewsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Position whereJobsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Position whereReviewsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Position whereSalariesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Position whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Position whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Position whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Position extends Model {

  public function jobs() {
    return $this->hasMany('App\Model\Job');
  }

  public function interviews() {
    return $this->hasMany('App\Model\Interview');
  }

  public function reviews() {
    return $this->hasMany('App\Model\Review');
  }

  public function salaries() {
    return $this->hasMany('App\Model\Salary');
  }

  /**
   * Scope a query to only include positions whose title or slug likes as $search
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param  string $search
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSearch($query, $search) {
    return $query->where('title', 'LIKE', "%$search%")
      ->orWhere('slug', 'LIKE', "%$search%");
  }

  //public function get($column) {
  //  switch ($column) {
  //    case 'of_position':
  //      return I18n::$lang == 'ru' ? Morpher::inflect($this->title, 'Р') : $this->title;
  //      break;
  //  }
  //  return parent::get($column);
  //}

  public function filters() {
    return [
      'slug' => [
        ['mb_strtolower'], //todo filter
      ],
    ];
  }

}