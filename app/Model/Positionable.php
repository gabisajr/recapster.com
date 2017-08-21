<?php

namespace App\Model;

/**
 * Trait Positionable
 * @package App\Model
 * @property Position|null $position
 * @property string $position_title
 */
trait Positionable {

  public function position() {
    return $this->belongsTo('App\Model\Position');
  }

  public function positionTitle() {
    if ($this->position) {
      return $this->position->title;
    }

    return $this->position_title;
  }

}