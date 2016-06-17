<?php

namespace EnhancedCRM\Exception;

/**
 * ConfigurationError class.
 */
class ConfigurationError extends BaseError
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
