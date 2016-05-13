<?php

namespace EnhancedCRM\Exception;

use Exception;

class BaseError extends Exception
{
    /**
     * @var int
     */
    public $httpStatusCode;

    /**
     * @var array
     */
    public $errors;

    /**
     * @var string
     */
    public $meta;

    /**
     * BaseError constructor.
     *
     * @param string $httpStatusCode
     * @param int    $response
     */
    public function __construct($httpStatusCode, $response)
    {
        $this->httpStatusCode = $httpStatusCode;
        $this->errors = array_map(function($data){ return $data['error'];  }, $response['errors']);

        $this->meta = $response['meta'];

        $extractError = function($error) {
            return "resource=" . @$error['resource'] . " field=" . @$error['field'] . " code=" . $error['code'] . " message=" . $error['message'];
        };

        $msg = implode("\n", array_map($extractError, $this->errors));

        parent::__construct($msg);
    }

    /**
     * @return int|string
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->meta['logref'];
    }
}
