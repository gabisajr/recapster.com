<?php

namespace App\Search\Form\Filter;

use App\Search\Form\SearchForm;

class FilterCity extends Filter {

  public function __construct(SearchForm $form) {

    $city_id = $form->getValue('city_id');
    $cities = $form->getCities();

    parent::__construct([
      'title' => __('Город'),
      'name'  => 'city',
      'value' => $city_id,
      'items' => $cities,
    ]);
  }

}