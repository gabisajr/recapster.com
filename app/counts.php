<?php

function getNumEnding($number, $endingArray) {
  $number = $number % 100;
  if ($number >= 11 && $number <= 19) {
    $ending = $endingArray[2];
  } else {
    $i = $number % 10;
    switch ($i) {
      case (1):
        $ending = $endingArray[0];
        break;
      case (2):
      case (3):
      case (4):
        $ending = $endingArray[1];
        break;
      default:
        $ending = $endingArray[2];
    }
  }
  return $ending;
}

//N видов деятельности
function industries_count($count) {
  if ($count) {
    $text = __(':count :industries', [
      ':count'      => $count,
      ':industries' => getNumEnding($count, [__('вид деятельности'), __('вида деятельности'), __('видов деятельности')]),
    ]);
  } else {
    $text = __('нет видов деятельности');
  }

  return $text;
}

function photos_count($count) {
  if ($count) {
    return $count . ' ' . getNumEnding($count, [__('фотография'), __('фотографии'), __('фотографий')]);
  }
  return __("нет фотографий");
}

function jobs_count($count) {
  if ($count) {
    return $count . ' ' . getNumEnding($count, [__('вакансия'), __('вакансии'), __('вакансий')]);
  }
  return __("нет вакансий");
}

function reviews_count($count) {
  if ($count) {
    return $count . ' ' . getNumEnding($count, [__('отзыв'), __('отзыва'), __('отзывов')]);
  }
  return __("нет отзывов");
}

function positions_count($count) {
  if ($count) {
    return $count . ' ' . getNumEnding($count, [__('профессия'), __('профессии'), __('профессий')]);
  }
  return __("нет профессий");
}

function cities_count($count) {
  if ($count) {
    return $count . ' ' . getNumEnding($count, [__('город'), __('города'), __('городов')]);
  }
  return __("нет городов");
}

function companies_count($count) {
  if ($count) {
    return $count . ' ' . getNumEnding($count, [__('компания'), __('компании'), __('компаний')]);
  }
  return __("нет компаний");
}

function users_count($count) {
  if ($count) {
    return $count . ' ' . getNumEnding($count, [__('пользователь'), __('пользователя'), __('пользователей')]);
  }
  return __("нет пользователей");
}

function universities_count($count) {
  if ($count) {
    return $count . ' ' . getNumEnding($count, [__('университет'), __('университета'), __('университетов')]);
  }
  return __("нет университетов");
}

function faculties_count($count) {
  if ($count) {
    return $count . ' ' . getNumEnding($count, [__('факультет'), __('факультета'), __('факультетов')]);
  }
  return __("нет факультетов");
}

//"Найдено 10 компаний"
function found_companies($count) {

  if ($count) {
    $text = __(':found :count :companies', [
      ':found'     => $count > 1 ? __('Найдено') : __('Найдена'),
      ':count'     => $count,
      ':companies' => getNumEnding($count, [__('компания'), __('компании'), __('компаний')]),
    ]);
  } else {
    $text = __('Ничего не найдено');
  }

  return $text;
}

//"Найдено 10 вакансий"
function found_jobs($count) {

  if ($count) {
    $text = __(':found :count :jobs', [
      ':found' => $count > 1 ? __('Найдено') : __('Найдена'),
      ':count' => $count,
      ':jobs'  => getNumEnding($count, [__('вакансия'), __('вакансии'), __('вакансий')]),
    ]);
  } else {
    $text = __('Ничего не найдено');
  }

  return $text;
}