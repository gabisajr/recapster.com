<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CompanyRevenue extends GraphQLType {

  protected $attributes = [
    'name' => 'CompanyRevenue',
  ];

  public function fields() {
    return [
      'id'    => [
        'type' => Type::nonNull(Type::int()),
      ],
      'title' => [
        'type' => Type::nonNull(Type::string()),
      ],
    ];
  }

}