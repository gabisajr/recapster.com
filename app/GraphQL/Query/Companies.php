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
      'id'        => ['name' => 'id', 'type' => Type::int(), 'description' => "Get a company by id"],
      'search'    => ['type' => Type::string(), 'description' => "Find companies by title or slug"],
      'confirmed' => ['type' => Type::boolean(), 'description' => "Set <i>true</i> for return only confirmed companies"],
    ];
  }

  public function resolve($root, $args) {

    /** @var Company $query */
    $query = Company::query();

    //фильтр по id
    if ($id = array_get($args, 'id')) {
      $query->where('id', '=', $id);
    }

    //фильтр по строке поиска
    if ($search = array_get($args, 'search')) {
      $query->search($search);
    }

    //только подтвержденые компании
    if ($confirmed = array_get($args, 'confirmed')) {
      $query->confirmed();
    }

    return $query->get();
  }

}