<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class Chair extends GraphQLType {

  protected $attributes = [
    'name' => 'Chair',
  ];

  public function fields() {
    return [
      'id'    => [
        'type' => Type::nonNull(Type::int()),
      ],
      'title' => [
        'type' => Type::string(),
      ],
    ];
  }

}