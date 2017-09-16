<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Model\Country;

class Countries extends Query {

  protected $attributes = [
    'name' => 'countries',
  ];

  public function type() {
    return Type::listOf(GraphQL::type('Country'));
  }

  public function args() {
    return [
      'id' => ['name' => 'id', 'type' => Type::int()],
    ];
  }

  public function resolve($root, $args) {

    $query = Country::query();

    //фильтр по id
    if ($id = array_get($args, 'id')) {
      $query->where('id', '=', $id);
    }

    return $query->get();
  }

}