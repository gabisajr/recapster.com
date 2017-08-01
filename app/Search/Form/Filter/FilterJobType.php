<?php

namespace App\Search\Form\Filter;

use App\Model\Job;
use App\Search\Form\SearchFormJobs;

class FilterJobType extends Filter {

  public function __construct(SearchFormJobs $form) {

    $jobType = $form->getValue('jobType');
    $items = $this->getItems();

    parent::__construct([
      'title' => __('Тип работы'),
      'name'  => 'jobType',
      'value' => $jobType,
      'items' => $items,
    ]);
  }

  public function getItems() {

    //кол-во вакансий не стажировок
    $realJobsCount = Job::query()->approved()->notInternships()->count();

    //кол-во вакансий-стажировок
    $internshipJobsCount = Job::query()->approved()->internships()->count();

    $job_types = [
      [
        'title' => __('Любой тип'),
        'id'    => '',
        'count' => null,
      ],
      [
        'title' => __('Вакансии'),
        'id'    => 'job',
        'count' => $realJobsCount,
      ],
      [
        'title' => __('Стажировки'),
        'id'    => 'internship',
        'count' => $internshipJobsCount,
      ],
    ];

    return json_decode(json_encode($job_types));
  }

}