<?php

namespace App\Search\Form\Filter;

abstract class Filter {

  protected $_data;

  public function __construct(array $data = null) {
    $this->_data = $data;
  }

  public function __toString() {
    return view('search/form/filter', $this->_data)->render();
  }

  public function value() {
    return array_get($this->_data, 'value');
  }

  public function name() {
    return array_get($this->_data, 'name');
  }

  public function mobile() {
    if (array_get($this->_data, 'name') == 'sort') return null;
    return view('search/form/mobile/filter', $this->_data)->render();
  }

  public function mobile_variants() {
    if (array_get($this->_data, 'name') == 'sort') return null;
    return view('search/form/mobile/variants', $this->_data)->render();
  }

  public function getItems() {
    return [];
  }

}