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
      'id'              => ['name' => 'id', 'type' => Type::int(), 'description' => 'Get a city by id'],
      'search'          => ['name' => 'search', 'type' => Type::string(), 'description' => 'Search city by title or slug'],
      'country'         => ['name' => 'country', 'type' => Type::int(), 'description' => 'Get cities of country'],
      'hasUniversities' => ['name' => 'hasUniversities', 'type' => Type::boolean(), 'description' => 'Get cities, which has one or more universities'],
    ];
  }

  public function resolve($root, $args) {

    /** @var City $query */
    $query = City::query();

    //фильтр по id
    if ($id = array_get($args, 'id')) {
      $query->where('id', '=', $id);
    }

    //фильтр по строке поиска
    if ($search = array_get($args, 'search')) {
      $query->search($search);
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