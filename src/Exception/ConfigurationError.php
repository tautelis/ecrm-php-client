<?php

namespace EnhancedCRM\Exception;

use Exception;

/**
 * ConfigurationError class.
 */
class ConfigurationError extends Exception
{
    /**
     * ConfigurationError constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
