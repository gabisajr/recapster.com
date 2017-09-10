<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CityType extends GraphQLType {

  protected $attributes = [
    'name'        => 'City',
    'description' => 'A city',
  ];

  public function fields() {
    return [
      'id'    => [
        'type'        => Type::nonNull(Type::int()),
        'description' => 'The id of the city',
      ],
      'slug'  => [
        'type'        => Type::string(),
        'description' => 'The unique city name in lower case in English',
      ],
      'title' => [
        'type'        => Type::string(),
        'description' => 'Title of the city in the real world',
      ],
    ];
  }

}