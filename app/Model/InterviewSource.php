<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Interview_Source - источник собеседования
 *
 * @property int    id
 * @property string title       - название источника
 * @property int    sort        - поле сортировки
 * @property bool   specifiable - источник может иметь уточнение
 */
class InterviewSource extends Model {

}