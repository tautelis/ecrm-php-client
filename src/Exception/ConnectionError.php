<?php

namespace EnhancedCRM\Exception;

class ConnectionError extends BaseError
{
    /**
     * @var string
     */
    protected $errno;

    /**
     * @var int
     */
    protected $errorMessage;

    /**
     * ConnectionError constructor.
     *
     * @param string $errno
     * @param int $error_message
     */
    public function __construct($errno, $error_message)
    {
        $this->errno = $errno;
        $this->errorMessage = $error_message;
        $msg = "Unexpected network error occurred during communication"
            . " with base api servers. Errno={$this->errno} Message={$this->errorMessage}.";

        parent::__construct($msg);
    }

    public function getErrno()
    {
        return $this->errno;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
