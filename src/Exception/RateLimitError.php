<?php

namespace EnhancedCRM\Exception;

class RateLimitError extends BaseError
{
  public function __construct()
  {
    $msg = 'The api rate limit was exceeded. '
      . 'Contact eCRM Support in order to change the rate limits for your account';
    parent::__construct($msg);
  }
}
