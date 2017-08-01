<?php

namespace App\Search\Form\Filter;

class FilterType extends Filter {

  private $placeholders;

  public function __construct(string $type) {

    $this->placeholders = $this->get_placeholders();

    parent::__construct([
      'title' => __('Тип поиска'),
      'name'  => 'type',
      'value' => $type,
      'items' => $this->getItems(),
    ]);
  }

  public function getItems() {

    $items = [
      [
        'id'          => 'jobs',
        'title'       => __('Вакансии'),
        'placeholder' => array_get($this->placeholders, 'jobs'),
      ],
      [
        'id'          => 'companies',
        'title'       => __('Компании'),
        'placeholder' => array_get($this->placeholders, 'companies'),
      ],
      [
        'id'          => 'reviews',
        'title'       => __('Отзывы'),
        'placeholder' => array_get($this->placeholders, 'reviews'),
      ],
    ];

    return json_decode(json_encode($items));
  }

  public function placeholder() {
    $type = array_get($this->_data, 'value');
    return array_get($this->placeholders, $type);
  }

  private function get_placeholders() {
    return [
      'jobs'      => __('Должность или компания'),
      'companies' => __('Название компании'),
      'reviews'   => __('Компания или должность'),
    ];
  }

}