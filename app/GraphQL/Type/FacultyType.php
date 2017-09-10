<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class FacultyType extends GraphQLType {

  protected $attributes = [
    'name' => 'Faculty',
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