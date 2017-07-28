<?php

namespace App;

class Status {
  const APPROVED = 'approved';
  const PENDING = 'pending';
  const REJECTED = 'rejected';
  const DRAFT = 'draft';

  public static $all = [
    self::PENDING,
    self::APPROVED,
    self::REJECTED,
    self::DRAFT,
  ];

}