<?php

namespace App\Search\Form\Filter;

use App\Search\Form\SearchForm;

class FilterIndustry extends Filter {

  public function __construct(SearchForm $form) {

    $industryId = $form->getValue('industryId');
    $industries = $form->getIndustries();

    parent::__construct([
      'title' => __('Направление'),
      'name'  => 'industry',
      'value' => $industryId,
      'items' => $industries,
    ]);
  }

}