<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App;


/**
 * App\Model\Company
 *
 * @property int $id
 * @property string $alias
 * @property string $title
 * @property float $rating
 * @property int|null $created_user_id
 * @property int|null $updated_user_id
 * @property int|null $logo_id
 * @property int|null $cover_id
 * @property string|null $site
 * @property string|null $short_desc короткое описание компании
 * @property int|null $size_id размер компании (кол-во сотрудников)
 * @property int|null $revenue_id доход компании
 * @property int|null $hq_city_id город где находится головной офис
 * @property int|null $foundation_year год основания
 * @property string|null $description описание компании
 * @property int $confirmed подтвержденый аккаунт
 * @property int $active активированая компания
 * @property int $reviews_count количество активных отзывов
 * @property int $salaries_count количество активных зарплат
 * @property int $interviews_count количество активных собеседований
 * @property int $jobs_count количество вакансий
 * @property int $internship_count количество стажировок
 * @property int $benefits_count количество активных приемуществ
 * @property int $images_count количество активных фотографий
 * @property int $followers_count количество подписчиков
 * @property string|null $tel телефон
 * @property int|null $vk_group_id id группы ВКонтакте
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\User $addedUser
 * @property-read \App\Model\Ceo $ceo
 * @property-read \App\Model\Image|null $cover
 * @property-read \App\Model\City|null $hqCity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Image[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Industry[] $industries
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Interview[] $interviews
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Job[] $jobs
 * @property-read \App\Model\Image|null $logo
 * @property-read \App\Model\CompanyRevenue|null $revenue
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Review[] $reviews
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Salary[] $salaries
 * @property-read \App\Model\CompanySize|null $size
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Subscription[] $subscribers
 * @property-read \App\Model\User|null $updatedUser
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company city($city)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company confirmed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company industry()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company notActive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company unconfirmed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereBenefitsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereCoverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereCreatedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereFollowersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereFoundationYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereHqCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereImagesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereInternshipCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereInterviewsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereJobsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereLogoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereRevenueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereReviewsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereSalariesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereShortDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereSizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereUpdatedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Company whereVkGroupId($value)
 * @mixin \Eloquent
 */
class Company extends Model {

  public function ceo() {
    return $this->hasOne('App\Model\Ceo', 'company_id');
  }

  public function industries() {
    return $this->belongsToMany('App\Model\Industry', 'company_industries');
  }

  public function reviews() {
    return $this->hasMany('App\Model\Review', 'company_id');
  }

  public function salaries() {
    return $this->hasMany('App\Model\Salary', 'company_id');
  }

  public function interviews() {
    return $this->hasMany('App\Model\Interview', 'company_id');
  }

  public function images() {
    return $this->belongsToMany('App\Model\Image', 'company_images');
  }

  public function jobs() {
    return $this->hasMany('App\Model\Job', 'company_id');
  }

  public function logo() {
    return $this->belongsTo('App\Model\Image');
  }

  public function cover() {
    return $this->belongsTo('App\Model\Image');
  }

  public function size() {
    return $this->belongsTo('App\Model\CompanySize');
  }

  public function revenue() {
    return $this->belongsTo('App\Model\CompanyRevenue');
  }

  public function hqCity() {
    return $this->belongsTo('App\Model\City', 'hq_city_id');
  }

  public function addedUser() {
    return $this->belongsTo('App\Model\User', 'added_user_id');
  }

  public function updatedUser() {
    return $this->belongsTo('App\Model\User', 'updated_user_id');
  }

  public function subscribers() {
    return $this->morphMany('App\Model\Subscription', 'subscriptions');
  }

  /**
   * Scope a query to only include active companies.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param int|City $city
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeCity($query, $city) {
    $cityId = null;
    if ($city instanceof City) {
      $cityId = $city->id;
    } elseif (is_numeric($city)) {
      $cityId = $city;
    }
    if ($cityId) {
      return $query->where('hq_city_id', '=', $cityId);
    }
    return $query;
  }

  public function scopeIndustry($query) {
    //todo ..industry param
    //todo join
  }

  /**
   * Scope a query to only include active companies.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeActive($query) {
    return $query->where('active', '=', true);
  }

  /**
   * Scope a query to only include not active companies.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeNotActive($query) {
    return $query->where('active', '=', false)->orWhere('active', '=', null);
  }

  /**
   * Scope a query to only companies, which title or alias like $search string.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param  string $search
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSearch($query, $search) {
    return $query->where('title', 'LIKE', "%$search%")
      ->orWhere('alias', 'LIKE', "%$search%");
  }

  /**
   * Scope a query to only include confirmed companies.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeConfirmed($query) {
    return $query->where('confirmed', '=', true);
  }

  /**
   * Scope a query to only include unconfirmed companies.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeUnconfirmed($query) {
    return $query->where('confirmed', '=', false);
  }

  //todo relation
  protected $_has_many = [
    'followers' => [
      'model'       => 'User',
      'foreign_key' => 'company_id',
      'far_key'     => 'user_id',
      'through'     => 'subscriptions',
    ],
  ];

  public function filters() {
    return [
      'site' => [
        ['mb_strtolower'],
        [function ($value) {
          if (!$value) return $value;

          $filter_value = $value;
          if (!preg_match('/^https?:\/\/.+/', $value)) {
            $filter_value = preg_replace('/^.+:\/\//', '', $value);
            $filter_value = "http://$filter_value";
          }

          return $filter_value;
        }],
      ],
    ];
  }

  //public function create(Validation $validation = null) {
  //  $this->added = date("Y-m-d H:i:s");
  //  $this->added_user = Auth::instance()->get_user();
  //  return parent::create($validation);
  //}

  public function create_by_user(Model_User $user = null) {

    $title = Arr::get($_POST, 'company_title');
    $data = Arr::get($_POST, 'new_company', []);
    $site = Arr::get($data, 'site');
    $hq_city = ORM::factory('City', Arr::get($data, 'hq'));
    $size = ORM::factory('Company_Size', Arr::get($data, 'size'));

    /** @var Model_Company $company */
    $company = ORM::factory('Company');
    if ($user && $user->loaded()) $company->added_user = $user;
    $company->title = $title;
    if (!empty($site)) $company->site = $site;
    if ($hq_city->loaded()) $company->hq = $hq_city;
    if ($size->loaded()) $company->size = $size;
    $company->save();

    return $company;
  }

  public function admin_notify_new_company() {
    if (!$this->loaded()) throw  new Exception('Company not loaded');

    $app_name = Kohana::$config->load('app')->get('app_name');
    $subject = __('Новая компания на :app_name', [':app_name' => $app_name]);
    $email_html = View::factory('email/notify-company', ['company' => $this, 'app_name' => $app_name])->render();
    Email::instance()->send_admin($subject, $email_html);
  }

  //todo observers
  //public function update(Validation $validation = null) {
  //  $user = Auth::instance()->get_user();
  //  if ($user) $this->last_updated_user = $user;
  //  return parent::update($validation);
  //}
  //
  //public function save(Validation $validation = null) {
  //
  //  if (!empty($this->site)) {
  //    $site_title = preg_replace('/^https?:\/\//', '', $this->site);
  //    $site_title = preg_replace('/\/$/', '', $site_title);
  //    $this->site_title = $site_title;
  //  }
  //
  //  return parent::save($validation);
  //}
  //
  //public function delete() { //todo observer
  //
  //  /** @var ORM $item */
  //
  //  //delete ceo
  //  if ($this->ceo->loaded()) $this->ceo->delete();
  //
  //  //delete reviews
  //  foreach ($this->reviews->find_all() as $item) $item->delete();
  //
  //  //delete salaries
  //  foreach ($this->salaries->find_all() as $item) $item->delete();
  //
  //  //delete interviews
  //  foreach ($this->interviews->find_all() as $item) $item->delete();
  //
  //  //delete images
  //  foreach ($this->images->find_all() as $item) $item->delete();
  //
  //  //delete jobs
  //  foreach ($this->jobs->find_all() as $item) $item->delete();
  //
  //  //delete activities
  //  foreach ($this->activities->find_all() as $activity) $activity->delete();
  //
  //  //delete logo
  //  if ($this->logo->loaded()) $this->logo->delete();
  //
  //  //delete cover
  //  if ($this->cover->loaded()) $this->cover->delete();
  //
  //  return parent::delete();
  //
  //}

  public function ofCompany() {
    if (App::isLocale('ru')) {
      Morpher::inflect($this->title, 'Р');
    }
    return $this->title;
  }

  public function forCompany() {
    return $this->ofCompany();
  }

  public function aboutCompany() {
    if (App::isLocale('ru')) {
      return Morpher::inflect($this->title, 'П');
    }
    return $this->title;
  }

  public function inCompany() {
    return $this->aboutCompany();
  }

  public function url(string $section = "profile") {
    if (!$this->active) return '#';
    return route('company.profile', ['company' => $this->alias]);

    //todo use other routes for company page sections
    $section = mb_strtolower($section);
    if ($section && $section != 'profile') $url .= "/{$section}/";
    return $url;
  }

  public function adminUrl() {
    if (!$this->exists) return "#";
    return route('admin.company.edit', ['id' => $this->id]);
  }

  public function add_review_url() {
    $url = "http://$_SERVER[HTTP_HOST]/add/review";
    if ($this->loaded()) $url .= "?company={$this->id}";
    return $url;
  }

  public function add_salary_url() {
    $url = "http://$_SERVER[HTTP_HOST]/add/salary";
    if ($this->loaded()) $url .= "?company={$this->id}";
    return $url;
  }

  public function add_interview_url() {
    $url = "http://$_SERVER[HTTP_HOST]/add/interview";
    if ($this->loaded()) $url .= "?company={$this->id}";
    return $url;
  }

  public function addPhotoUrl() {
    if (!$this->exists) return '#';
    $url = url("/company/uploadImages/{$this->id}"); //todo route
    return $url;
  }

  public function add_benefit_url() {
    $url = "http://$_SERVER[HTTP_HOST]/add/benefit";
    if ($this->loaded()) $url .= "?company={$this->id}";
    return $url;
  }

  /**
   * пересчитать рейтинг компании
   *
   * @return $this
   */
  public function recount_rating() {

    $this->rating = (float)DB::select([DB::expr('AVG(rating)'), 'rating'])
      ->from('reviews')->where('company_id', '=', $this->id)
      ->and_where('status', '=', Status::APPROVED)
      ->group_by('company_id')
      ->execute()
      ->get('rating');

    return $this->save();
  }

  /**
   * пересчитать и сохранить кол-во активных отзывов
   *
   * @return Model_Company
   */
  public function recount_reviews() {
    $this->reviews_count = $this->reviews->where('status', '=', Status::APPROVED)->count_all();
    return $this->save();
  }

  /**
   * пересчитать и сохранить кол-во активных зарплат
   *
   * @return Model_Company
   */
  public function recount_salaries() {
    $this->salaries_count = $this->salaries->where('status', '=', Status::APPROVED)->count_all();
    return $this->save();
  }

  /**
   * пересчитать и сохранить кол-во активных собеседований
   *
   * @return Model_Company
   */
  public function recount_interviews() {
    $this->interviews_count = $this->interviews->where('status', '=', Status::APPROVED)->count_all();
    return $this->save();
  }

  /**
   * пересчитать и сохранить кол-во активных вакансий
   *
   * @return Model_Company
   */
  public function recount_jobs() {
    $this->jobs_count = $this->jobs->where('status', '=', Status::APPROVED)->count_all();
    return $this->save();
  }

  /**
   * пересчитать и сохранить кол-во активных фотографий
   *
   * @return Model_Company
   */
  public function recount_images() {
    $this->images_count = $this->images->where('status', '=', Status::APPROVED)->count_all();
    return $this->save();
  }

  /**
   * пересчитать и сохранить кол-во подписчиков
   *
   * @return Model_Company
   */
  public function recount_followers() {
    $this->followers_count = $this->followers->where('user.confirmed', '=', true)->count_all();
    return $this->save();
  }

  public static function route_filter_alias($route, $params, $request) {

    $alias = Arr::get($params, 'company_alias');
    $company = ORM::factory('Company', ['alias' => $alias, 'active' => true]);
    $request->company = $company;

    if (!empty($alias)) return $company->loaded();

    return null;
  }

  //public static function exist($id) {
  //  return ORM::factory('Company', $id)->loaded();
  //}

  /**
   * сколько процентов рекомендуют друзьям из проголосовавших
   *
   * @param bool|true $round - использовать ли округление
   * @return float
   */
  public function get_recommend_percent($round = true) {

    /**
     * подсчет только среди обобренных отзывов
     *
     * @var $votes_count - Общее количество голосов: "Да", "Нет", не голосовавших - не учитываем
     * @var $positive_count - Количество голосов "Да"
     */

    $votes_count = $this->reviews
      ->where('status', '=', Status::APPROVED)
      ->and_where('recommend', 'IN', [Bit::YES, Bit::NO])
      ->count_all();

    $positive_count = $this->reviews
      ->where('status', '=', Status::APPROVED)
      ->and_where('recommend', '=', Bit::YES)
      ->count_all();

    $percent = null;

    if ($votes_count > 0) {
      $percent = $positive_count / $votes_count * 100;
      if ($round) $percent = round($percent);
    }

    return $percent;
  }

  /**
   * сколько процентов доверяют руководителю
   *
   * @param bool|true $round - использовать ли округление
   * @return float|null - Null если никто не голосовал еще вообще по этому критирею
   */
  public function get_ceo_rate_positive_percent($round = true) {

    /**
     * подсчет только среди обобренных отзывов
     *
     * @var $votes_count - Общее количество голосов: "За", "Против", "Нейтралы", не голосовавших - не учитываем
     * @var $positive_count - Количество голосов "За"
     */

    $votes_count = $this->reviews
      ->where('status', '=', Status::APPROVED)
      ->and_where('ceo_rate', 'IN', [Opinion::NEGATIVE, Opinion::NEUTRAL, Opinion::POSITIVE])
      ->count_all();

    $positive_count = $this->reviews
      ->where('status', '=', Status::APPROVED)
      ->and_where('ceo_rate', '=', Opinion::POSITIVE)
      ->count_all();

    $percent = null;

    if ($votes_count) {
      $percent = $positive_count / $votes_count * 100;
      if ($round) $percent = round($percent);
    }

    return $percent;
  }

  /**
   * сколько проголосовали за руковдителя "Доверяю"
   *
   * @return int
   */
  public function get_ceo_rate_positive_count() {
    return $this->reviews
      ->where('status', '=', Status::APPROVED)
      ->and_where('ceo_rate', '=', Opinion::POSITIVE)
      ->count_all();
  }

  /**
   * @param Model_User $user
   * @param array $data_arr
   * @return Model_Image[]
   */
  public function add_images(Model_User $user, array $data_arr = []) {
    $added_images = [];

    foreach ($data_arr as $image_data) {
      $image = $this->add_image($user, $image_data);
      if ($image) $added_images[] = $image;
    }

    return $added_images;
  }

  /**
   * @param Model_User $user
   * @param array $values
   * @return Model_Image|null
   */
  public function add_image(Model_User $user, Array $values = []) {

    $upload_path = Arr::get($values, 'upload_path');
    $title = Arr::get($values, 'title');
    $city_id = Arr::get($values, 'city_id');
    $anonym = Arr::get($values, 'anonym');

    //проверка существует ли временный файл фотографии
    if (file_exists(DOCROOT . $upload_path) && !is_dir(DOCROOT . $upload_path)) {

      $name = pathinfo($upload_path, PATHINFO_BASENAME);
      $destination = "/images/company/$name";

      //перемещаем в целевую папку
      if (rename(DOCROOT . $upload_path, DOCROOT . $destination)) {
        /** @var Model_Image $image */
        $image = ORM::factory('Image');
        $image->path = $destination;
        $image->title = $title;
        $image->user = $user;
        $image->city_id = ORM::factory('City', $city_id)->id;
        $image->anonym = $anonym;
        $image->save();
        $this->add('images', $image);

        return $image;

      }
    }

    return null;
  }

  /**
   * получить самый популярный отзыв
   *
   * @return Model_Review
   */
  public function get_featured_review() {
    return ORM::factory('Review')
      ->select([DB::expr("(SELECT COUNT(*) FROM helpful
      WHERE helpful.object_id = review.id
      AND helpful.object_type = 'review'
      AND helpful.helpful_direction = 'yes')"), 'helpful_value'])
      ->where('review.company_id', '=', $this->id)
      ->and_where('review.status', '=', Status::APPROVED)
      ->order_by('helpful_value', 'DESC')//по полезности
      ->order_by('added', 'DESC')//по дате
      ->limit(1)
      ->find();
  }

  /**
   * @return int количество новых (ожидающих) откиков на все вакансии компании
   */
  public function count_new_job_applications() {
    return ORM::factory('Job_Application')
      ->join('jobs', 'LEFT')->on('job_application.job_id', '=', 'jobs.id')
      ->where('job_application.status', '=', Status::PENDING)
      ->and_where('jobs.company_id', '=', $this->id)
      ->count_all();
  }

  /**
   * @param Model_User $user
   * @return bool
   */
  public function has_user_review($user) {
    if (!$user) return false;
    if (is_int($user)) $user_id = $user;
    else $user_id = $user->id;

    return ORM::factory('Review', [
      'user_id'    => $user_id,
      'company_id' => $this->id,
    ])->loaded();

  }

}