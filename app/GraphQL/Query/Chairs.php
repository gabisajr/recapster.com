<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Model\Chair;

class Chairs extends Query {

  protected $attributes = [
    'name' => 'chairs',
  ];

  public function type() {
    return Type::listOf(GraphQL::type('Chair'));
  }

  public function args() {
    return [
      'id'      => ['name' => 'id', 'type' => Type::int()],
      'faculty' => ['name' => 'faculty', 'type' => Type::int()],
    ];
  }

  public function resolve($root, $args) {

    /** @var Chair $query */
    $query = Chair::query();

    //фильтр по id
    if ($id = array_get($args, 'id')) {
      $query->where('id', '=', $id);
    }

    //фильтр по факультету
    if ($faculty = array_get($args, 'faculty')) {
      $query->ofFaculty($faculty);
    }

    //default order
    $query->orderBy('title');

    return $query->get();
  }

}