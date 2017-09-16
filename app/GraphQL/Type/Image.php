<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class Image extends GraphQLType {

  protected $attributes = [
    'name' => 'Image',
  ];

  public function fields() {
    return [
      'id'   => [
        'type' => Type::nonNull(Type::int()),
      ],
      'path' => [
        'type' => Type::string(),
      ],
    ];
  }

}