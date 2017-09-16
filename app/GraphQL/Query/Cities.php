<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Model\City;

class Cities extends Query {

  protected $attributes = [
    'name' => 'cities',
  ];

  public function type() {
    return Type::listOf(GraphQL::type('City'));
  }

  public function args() {
    return [
      'id'              => ['name' => 'id', 'type' => Type::int()],
      'slug'            => ['name' => 'slug', 'type' => Type::string()],
      'title'           => ['name' => 'title', 'type' => Type::string()],
      'country'         => ['name' => 'country', 'type' => Type::int()],
      'hasUniversities' => ['name' => 'hasUniversities', 'type' => Type::boolean()],
    ];
  }

  public function resolve($root, $args) {

    $query = City::query();

    //фильтр по id
    if ($id = array_get($args, 'id')) {
      $query->where('id', '=', $id);
    }

    //фильтр по slug
    if ($slug = array_get($args, 'slug')) {
      $query->where('slug', '=', $slug);
    }

    //фильтр по стране
    if ($country = array_get($args, 'country')) {
      $query->ofCountry($country);
    }

    //города с университетами
    if ($hasUniversities = array_get($args, 'hasUniversities')) {
      $query->has('universities');
    }

    return $query->get();
  }

}