<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class UniversityType extends GraphQLType {

  protected $attributes = [
    'name'        => 'University',
    'description' => 'A university',
  ];

  public function fields() {
    return [
      'id'           => [
        'type'        => Type::nonNull(Type::int()),
        'description' => 'The id of the university',
      ],
      'slug'         => [
        'type'        => Type::string(),
        'description' => 'The unique university name in lower case in English',
      ],
      'title'        => [
        'type'        => Type::string(),
        'description' => 'Title of the university in the real world',
      ],
      'abbreviation' => [
        'type'        => Type::string(),
        'description' => 'Short form of university name',
      ],
      'site'         => [
        'type'        => Type::string(),
        'description' => 'official web-site',
      ],
    ];
  }

}