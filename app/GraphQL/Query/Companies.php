<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Model\Company;

class Companies extends Query {

  protected $attributes = [
    'name' => 'companies',
  ];

  public function type() {
    return Type::listOf(GraphQL::type('Company'));
  }

  public function args() {
    return [
      'id' => ['name' => 'id', 'type' => Type::int()],
    ];
  }

  public function resolve($root, $args) {

    $query = Company::query();

    //фильтр по id
    if ($id = array_get($args, 'id')) {
      $query->where('id', '=', $id);
    }

    return $query->get();
  }

}