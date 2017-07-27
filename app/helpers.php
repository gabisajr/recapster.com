<?php

function disable_email_link($email) {
  $email = str_replace('@', '<span>@</span>', $email);
  $email = str_replace('.', '<span>.</span>', $email);
  return $email;
}

function href_tel(string $rawTel) {
  $tel = preg_replace('/(\s+|\(|\))/', '', $rawTel);
  return "tel:$tel";
}

function transliterate(string $input) {
  $gost = [
    "Є"  => "YE", "І" => "I", "Ѓ" => "G", "і" => "i", "№" => "-", "є" => "ye", "ѓ" => "g",
    "А"  => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D",
    "Е"  => "E", "Ё" => "YO", "Ж" => "ZH",
    "З"  => "Z", "И" => "I", "Й" => "J", "К" => "K", "Л" => "L",
    "М"  => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R",
    "С"  => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "X",
    "Ц"  => "C", "Ч" => "CH", "Ш" => "SH", "Щ" => "SHH", "Ъ" => "'",
    "Ы"  => "Y", "Ь" => "", "Э" => "E", "Ю" => "YU", "Я" => "YA",
    "а"  => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d",
    "е"  => "e", "ё" => "yo", "ж" => "zh",
    "з"  => "z", "и" => "i", "й" => "j", "к" => "k", "л" => "l",
    "м"  => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
    "с"  => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "x",
    "ц"  => "c", "ч" => "ch", "ш" => "sh", "щ" => "shh", "ъ" => "",
    "ы"  => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
    " "  => "-", "—" => "_", "," => "_", "!" => "_", "@" => "_",
    "#"  => "-", "$" => "", "%" => "", "^" => "", "&" => "", "*" => "",
    "("  => "", ")" => "", "+" => "", "=" => "", ";" => "", ":" => "",
    "'"  => "", "\"" => "", "~" => "", "`" => "", "?" => "", "/" => "",
    "\\" => "", "[" => "", "]" => "", "{" => "", "}" => "", "|" => "",
  ];

  return strtr($input, $gost);
}

function transliterateForUrl(string $text) {
  $result = strtolower(trim(transliterate($text)));
  $result = preg_replace("/[^0-9a-zA-Z_-]+/", "", $result);
  return $result;
}

function formatBytes($size, $precision = 1) {
  $base = log($size, 1024);
  $suffixes = ['', 'КБ', 'МБ', 'ГБ', 'ТБ'];

  return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[(int)floor($base)];
}

function svgIcon($iconName) {
  return "<svg class=\"svg-{$iconName}\"><use xlink:href=\"#{$iconName}\"></use></svg>";
}

function logo(\App\Model\Company $company, $size = 50) {
  return $company->logo ? $company->logo->resize($size, $size)->path : '/images/empty-logo.svg';
}

function logo_big(\App\Model\Company $company, $size = 210) {
  return $company->logo ? $company->logo->resize($size, $size)->path : '/images/empty-logo-big.svg';
}

//иконка подтвержденной компании
function icon_confirmed_company(\App\Model\Company $company, $powertip_placement = "e") {
  if ($company->confirmed) {
    $title = __('Подтвержденый');
    return "<i class='icon-confirmed powertip' title='{$title}' data-powertip-placement='{$powertip_placement}'></i>";
  }
  return null;
}

function insert_br($title) {

  $arr = [
    'тайм-кафе Штаб-Квартира' => 'тайм-кафе <br>Штаб-Квартира',
    '4DClick Internet Agency' => '4DClick <br>Internet Agency',
    'Гиппократ сеть аптек'    => 'Гиппократ <br>сеть аптек',
  ];

  return array_get($arr, $title, $title);
}

function html_attributes(array $attributes = []) {
  $attrs = [];
  foreach ($attributes as $key => $value) {
    if ($value) {
      $attrs[] = "$key=\"$value\"";
    } else {
      $attrs[] = "$key";
    }
  }

  $attrs = join(" ", $attrs);
  if ($attrs) $attrs = " $attrs "; //wrap by whitespaces

  return $attrs;
}

function visibility($object) {
  if ($object->anonym) {
    $text = __('Анонимно');
    $html = "<i class='fa fa-fw fa-lock text-muted' aria-hidden='true' title='{$text}'></i>";
  } else {
    $text = __('Публично');
    $html = "<i class='fa fa-fw fa-globe' style='color: #16abf5' aria-hidden='true' title='{$text}'></i>";
  }
  return $html;
}

/**
 * получить надпись о статусе по код стутуса
 *
 * @param null   $status_code
 * @param string $gender род: m, f, n - мужской, женский, средний
 * @return string
 */
function status($status_code = null, $gender = 'm') {

  switch ($status_code) {
    case \App\Status::PENDING:
      $status_caption = __('в ожидании');
      break;

    case \App\Status::APPROVED:
      $status_caption = $gender == 'm' ? __('одобрен') : ($gender == 'f' ? __('одобрена') : __('одобрено'));
      break;

    case \App\Status::REMOVED:
      $status_caption = $gender == 'm' ? __('отклонен') : ($gender == 'f' ? __('отклонена') : __('отклонено'));
      break;

    case \App\Status::ARCHIVED:
      $status_caption = $gender == 'm' ? __('архвирован') : ($gender == 'f' ? __('архвирована') : __('архвировано'));
      break;

    case \App\Status::DRAFT:
      $status_caption = __('черновик');
      break;

    default:
      $status_caption = __('неизвестный');
      break;
  }

  return $status_caption;
}