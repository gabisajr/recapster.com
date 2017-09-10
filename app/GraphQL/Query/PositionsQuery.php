<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Model\Position;

class PositionsQuery extends Query {

  protected $attributes = [
    'name' => 'positions',
  ];

  public function type() {
    return Type::listOf(GraphQL::type('Position'));
  }

  public function args() {
    return [
      'id'     => ['name' => 'id', 'type' => Type::int()],
      'search' => ['name' => 'search', 'type' => Type::string()],
    ];
  }

  public function resolve($root, $args) {

    $query = Position::query();

    //фильтр по id
    if ($id = array_get($args, 'id')) {
      $query->where('id', '=', $id);
    }

    //фильтр по строке поиска
    if ($search = array_get($args, 'search')) {
      $query->search($search); //todo order by search entrance index
    }

    //default order
    $query->orderBy('title');

    return $query->get();
  }

}