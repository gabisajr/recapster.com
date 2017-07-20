<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag Тег к объектам (типа хештега)
 *
 * @property int    $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 */
class Tag extends Model {

  public function rules() { //todo validation
    return [
      'title' => [
        ['not_empty'],
        [[$this, 'unique'], ['title', ':value']],
      ],
    ];
  }

}