<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CompanySize extends GraphQLType {

  protected $attributes = [
    'name' => 'CompanySize',
  ];

  public function fields() {
    return [
      'id'              => [
        'type' => Type::nonNull(Type::int()),
      ],
      'slug'           => [
        'type' => Type::nonNull(Type::string()),
      ],
      'employees_count' => [
        'type' => Type::string(),
      ],
    ];
  }

}