<?php

namespace EnhancedCRM;

/**
 * Response class.
 */
class Response
{
    /**
     * @var int
     */
    protected $code;

    /**
     * @var resource
     */
    protected $resource;

    /**
     * Response constructor.
     *
     * @param int      $code
     * @param resource $resource
     */
    public function __construct($code, $resource)
    {
        $this->code = $code;
        $this->resource = $resource;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }
}
