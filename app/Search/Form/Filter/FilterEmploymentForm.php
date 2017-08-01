<?php

namespace App\Search\Form\Filter;

use App\Model\EmploymentForm;
use App\Search\Form\SearchForm;
use App\Status;
use DB;

class FilterEmploymentForm extends Filter {

  public function __construct(SearchForm $form) {
    parent::__construct([
      'title' => __('Занятость'),
      'name'  => 'employment',
      'value' => $form->getValue('employmentForm'),
      'items' => $this->getItems(),
    ]);
  }


  public function getItems() {
    $employmentForms = EmploymentForm::query()
      ->select('employment_forms.alias', 'employment_forms.id')
      ->leftJoin('jobs', 'jobs.employment_form_id', '=', 'employment_forms.id')
      ->select(DB::raw('COUNT(DISTINCT jobs.id) as count'))
      ->groupBy('employment_forms.id')
      ->where('jobs.status', '=', Status::APPROVED)
      ->orderBy('count', 'DESC')
      ->orderBy('employment_forms.sort')
      ->orderBy('employment_forms.title')
      ->get();

    $anyEmploymentForm = json_decode(json_encode([
      'title' => __('Любая занятость'),
      'id'    => null,
      'count' => null,
    ]));

    $employmentForms->prepend($anyEmploymentForm);

    return $employmentForms;
  }

}