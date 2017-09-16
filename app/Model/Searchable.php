<?php

namespace App\Model;

use DB;

trait Searchable {

  /**
   * Scope a query to only cities, which title or slug like $search string.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param  string $search
   * @param bool $occurrenceOrder - order result cities by search string's first occurrence index
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSearch($query, $search, $occurrenceOrder = true) {

    $table = $this->getTable();

    $sub = DB::table($table)
      ->select('*')
      ->addSelect(DB::raw("IF(POSITION('{$search}' in slug) > 0, POSITION('{$search}' in slug), null) as so_index_slug"))
      ->addSelect(DB::raw("IF(POSITION('{$search}' in title) > 0, POSITION('{$search}' in title), null) as so_index_title"))
      ->whereRaw("slug like '%$search%'")
      ->orWhereRaw("title like '%$search%'")
      ->toSql();

    $query
      ->select('*')
      ->from(DB::raw("($sub) as $table"));

    if ($occurrenceOrder) {
      $query->addSelect(DB::raw("CASE
                                      WHEN so_index_slug IS NULL THEN so_index_title
                                      WHEN so_index_title IS NULL THEN so_index_slug
                                      ELSE LEAST(so_index_slug, so_index_title)
                                    END as so_index"));

      $query->orderBy('so_index');
    }

    return $query;
  }

}