<?php

namespace App\GraphQL\Type;

use App\Model\Country as CountryModel;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class Country extends GraphQLType {

  protected $attributes = [
    'name'        => 'Country',
    'description' => 'A country',
  ];

  public function fields() {
    return [
      'id'           => [
        'type'        => Type::nonNull(Type::int()),
        'description' => 'The id of the city',
      ],
      'title'        => [
        'type'        => Type::string(),
        'description' => 'Title of the city in the real world',
      ],
      'iso_code'     => [
        'type'        => Type::string(),
        'description' => 'The unique country code by standart ISO 3166-1 alpha-2',
      ],
      'cities'       => [
        'type'        => Type::listOf(GraphQL::type('City')),
        'description' => 'Cities in this country',
        'args'        => [
          'id' => ['name' => 'id', 'type' => Type::int()],
        ],
        'resolve'     => function (CountryModel $country, $args) {
          $query = $country->cities();
          if ($id = array_get($args, 'id')) {
            $query->where('id', '=', $id);
          }
          return $query->get();
        },
      ],
      'universities' => [
        'type'        => Type::listOf(GraphQL::type('University')),
        'description' => 'Universities in this country',
      ],
    ];
  }

}