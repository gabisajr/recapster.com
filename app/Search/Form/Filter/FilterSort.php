<?php

namespace App\Search\Form\Filter;

use App\Search\Form\SearchForm;

class FilterSort extends Filter {

  public function __construct(SearchForm $form) {

    $sort = $form->getValue('sort');
    $sorts = $form->getSorts();

    parent::__construct([
      'title' => __('Сортировка'),
      'name'  => 'sort',
      'value' => $sort,
      'items' => $sorts,
    ]);
  }

}