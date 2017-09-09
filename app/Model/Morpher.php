<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Exception;

/**
 * Class Morpher - таблица склонений по падежам
 *
 * Иван Родил Девчонку Велел Тащить Пеленку
 *
 * едиснтвенное число:
 * @property string  И
 * @property string  Р
 * @property string  Д
 * @property string  В
 * @property string  Т
 * @property string  П
 *
 * множественное число:
 * @property string  МИ
 * @property string  МР
 * @property string  МД
 * @property string  МВ
 * @property string  МТ
 * @property string  МП
 *
 * @property boolean $approved - одобрен ли
 */
class Morpher extends Model {

  protected $table = "morpher";
  protected $primaryKey = "И";

  public static function inflect($text, $padeg) {
    if (!$text || !$padeg) return null;

    $text = trim($text);
    $padeg = mb_strtoupper($padeg);

    /** @var Model_Morpher $morpher */
    $morpher = Morpher::find($text);

    if (!$morpher) {

      $morpher = new Morpher();
      $morpher->И = $text;

      try {
        $url = "http://api.morpher.ru/WebService.asmx/GetXml?s=" . urlencode($text);
        $xmlinfo = simplexml_load_file($url);

        //единственное число
        $morpher->Р = (string)$xmlinfo->Р;
        $morpher->Д = (string)$xmlinfo->Д;
        $morpher->В = (string)$xmlinfo->В;
        $morpher->Т = (string)$xmlinfo->Т;
        $morpher->П = (string)$xmlinfo->П;

        //множественное число
        $morpher->МИ = (string)$xmlinfo->множественное->И;
        $morpher->МР = (string)$xmlinfo->множественное->Р;
        $morpher->МД = (string)$xmlinfo->множественное->Д;
        $morpher->МВ = (string)$xmlinfo->множественное->В;
        $morpher->МТ = (string)$xmlinfo->множественное->Т;
        $morpher->МП = (string)$xmlinfo->множественное->П;

      } catch (Exception $e) {

      }

      $morpher->save();

    }

    if (empty($morpher->{$padeg})) return $text;

    return $morpher->{$padeg};
  }

}