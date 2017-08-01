<?php

namespace App\Search\Form;

use App\Model\Country;
use App\Search\Form\Filter\Filter;
use App\Search\Form\Filter\FilterType;
use Auth;

abstract class SearchForm {

  protected $type;
  protected $_data;

  public function __construct(array $data = null) {
    $this->_data = $data;
  }

  public function __toString() {

    $filters = $this->getFilters();
    $hasFilter = false;
    foreach ($filters as $filter) {
      $value = $filter->value();
      $name = $filter->name();
      if ($value && $name != 'sort') {
        $hasFilter = true;
        break;
      }
    }

    $this->_data = [
        'typeFilter' => new FilterType($this->type),
        'filters'    => $filters,
        'hasFilter'  => $hasFilter,
      ] + $this->_data;

    return view('search.form', $this->_data)->render();
  }

  /** @return Filter[] */
  protected function getFilters() {
    return [];
  }

  public function getSorts() {
    return [];
  }

  public function getCities() {
    return [];
  }

  public function getIndustries() {
    return [];
  }

  public function getValue($name, $default = null) {
    return array_get($this->_data, $name, $default);
  }

  /**
   * @return Country
   */
  protected function getUserCountry() {
    $user = Auth::getUser();

    if ($user && $user->country) {
      $country = $user->country;
    } else {
      //todo find by ip address
      $country = Country::where('iso_code', '=', 'KZ')->first();
    }

    return $country;
  }

}