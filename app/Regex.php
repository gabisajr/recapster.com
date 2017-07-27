<?php

namespace App;

class Regex {

  const INPUT_PATTERN_ALIAS = '^[A-Za-z0-9]+[\-A-Za-z0-9]*[A-Za-z0-9]+$';
  const ALIAS = '/^[A-Za-z0-9]+[\-A-Za-z0-9]*[A-Za-z0-9]+$/';
  const TWITTER_LOGIN = '/^[A-Za-z0-9_]{1,15}$/';
  const INSTAGRAM_LOGIN = '/^[a-zA-Z0-9._]+$/';
  const USERNAME = '/^[0-9a-z][0-9a-z._-]{1,28}[0-9a-z]$/';

}