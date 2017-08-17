<?php

namespace App\Model;

use App\Status;

trait Approvable {

  /**
   * Scope a query with specific status
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param string $status
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeStatus($query, $status) {
    return $query->where('status', '=', $status);
  }

  /**
   * Scope a query only approved
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeApproved($query) {
    return $query->status(Status::APPROVED);
  }

}