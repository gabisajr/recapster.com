<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Model\Faculty;

class FacultiesQuery extends Query {

  protected $attributes = [
    'name' => 'faculties',
  ];

  public function type() {
    return Type::listOf(GraphQL::type('Faculty'));
  }

  public function args() {
    return [
      'id'         => ['name' => 'id', 'type' => Type::int()],
      'university' => ['name' => 'university', 'type' => Type::int()],
    ];
  }

  public function resolve($root, $args) {

    $query = Faculty::query();

    //фильтр по id
    if ($id = array_get($args, 'id')) {
      $query->where('id', '=', $id);
    }

    //фильтр по университету
    if ($university = array_get($args, 'university')) {
      $query->ofUniversity($university);
    }

    //default order
    $query->orderBy('title');

    return $query->get();
  }

}