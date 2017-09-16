<?php

namespace App\GraphQL\Type;

use App\Model\Country;
use GraphQL;
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
      'alias'           => [
        'type' => Type::nonNull(Type::string()),
      ],
      'employees_count' => [
        'type' => Type::string(),
      ],
    ];
  }

}