<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Model\University;

class UniversitiesQuery extends Query {

  protected $attributes = [
    'name' => 'universities',
  ];

  public function type() {
    return Type::listOf(GraphQL::type('University'));
  }

  public function args() {
    return [
      'id'      => ['name' => 'id', 'type' => Type::int()],
      'slug'    => ['name' => 'slug', 'type' => Type::string()],
      'city'    => ['name' => 'city', 'type' => Type::int()],
      'country' => ['name' => 'country', 'type' => Type::int()],
    ];
  }

  public function resolve($root, $args) {

    $query = University::query();

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

    //фильтр по городу
    if ($city = array_get($args, 'city')) {
      $query->ofCity($city);
    }

    return $query->get();
  }

}