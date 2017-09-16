<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\CompanyRevenue
 *
 * @property int $id
 * @property string $title
 * @property int $sort
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Company[] $companies
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CompanyRevenue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CompanyRevenue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CompanyRevenue whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CompanyRevenue whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CompanyRevenue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CompanyRevenue extends Model {

  public function companies() {
    return $this->hasMany('App\Model\Company', 'revenue_id');
  }

}