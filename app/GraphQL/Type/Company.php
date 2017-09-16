<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class Company extends GraphQLType {

  protected $attributes = [
    'name'        => 'Company',
    'description' => 'A company',
  ];

  public function fields() {
    return [
      'id'              => [
        'type'        => Type::nonNull(Type::int()),
        'description' => 'The id of the city',
      ],
      'slug'            => [
        'type'        => Type::string(),
        'description' => 'The unique city name in lower case in English',
      ],
      'title'           => [
        'type'        => Type::string(),
        'description' => 'Title of the city in the real world',
      ],
      'rating'          => [
        'type'        => Type::float(),
        'description' => "company rating built on employees' reviews",
      ],
      'logo'            => [
        'type'        => GraphQL::type('Image'),
        'description' => "company logo",
      ],
      'site'            => [
        'type'        => Type::string(),
        'description' => "official site of the company",
      ],
      'short_desc'      => [
        'type' => Type::string(),
      ],
      'size'            => [
        'type'        => GraphQL::type('CompanySize'),
        'description' => 'number of employees',
      ],
      'revenue'         => [
        'type'        => GraphQL::type('CompanyRevenue'),
        'description' => 'approximate revenue of the company per year',
      ],
      'hq'              => [
        'type'        => GraphQL::type('City'),
        'description' => 'location of the main office of the company',
      ],
      'foundation_year' => [
        'type'        => Type::int(),
        'description' => 'year of foundation of the company',
      ],
      'description'     => [
        'type' => Type::string(),
      ],
      'tel'             => [
        'type' => Type::string(),
      ],
      'confirmed'       => [
        'type' => Type::boolean(),
      ],
    ];
  }

}