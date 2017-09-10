<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class PositionType extends GraphQLType {

  protected $attributes = [
    'name' => 'Position',
  ];

  public function fields() {
    return [
      'id'    => [
        'type' => Type::nonNull(Type::int()),
      ],
      'title' => [
        'type' => Type::string(),
      ],
      'slug'  => [
        'type' => Type::string(),
      ],
    ];
  }

}