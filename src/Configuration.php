<?php

namespace EnhancedCRM;

/**
 * EnhancedCRM Configuration class.
 */
class Configuration
{
    const VERSION = "1";
    const URL_REGEXP = "/\b(?:(?:https?|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";

    /**
     * @var string Application access token.
     */
    public $accessToken;

    /**
     * @var string
     */
    public $baseUrl;

    /**
     * @var string
     */
    public $userAgent;

    /**
     * @var int Request timeout.
     */
    public $timeout;

    /**
     * @var bool For debug mode.
     */
    public $verbose;

    /**
     * Initiates a new Client configuration.
     *
     * @param array $options Client configuration settings
     *    - accessToken: Personal access token
     *    - baseUrl: Base url for the api. Default: "http://ecrm.demo.nfq.lt"
     *    - userAgent: Client user agent. Default: "EnhancedCRM/v1 PHP/{EnhancedCRM::VERSION}"
     *    - timeout: Request timeout. Default: 30 seconds
     *    - verbose: Verbose/debug mode. Default: false
     *
     * @throws \EnhancedCRM\Exception\ConfigurationError if no access token provided
     */
    public function __construct(array $options = [])
    {
        if (empty($options['accessToken']) || empty($options['baseUrl'])) {
            throw new Exception\ConfigurationError($this->_accessTokenIsMissing());
        }

        $this->accessToken = $options['accessToken'];
        $this->baseUrl = $options['baseUrl'];
        $this->userAgent = isset($options['userAgent']) ? $options['userAgent'] : "EnhancedCRM/v2 PHP/" . self::VERSION;
        $this->timeout = isset($options['timeout']) ? $options['timeout'] : 30;
        $this->verifySSL = isset($options['verifySSL']) ? $options['verifySSL'] : true;
        $this->verbose = isset($options['verbose']) ? $options['verbose'] : false;

        $this->validate();
    }

    /**
     * Checks if provided configuration is valid.
     *
     * @throws \EnhancedCRM\Exception\ConfigurationError if provided access token is invalid - contains disallowed characters
     * @throws \EnhancedCRM\Exception\ConfigurationError if provided access token is invalid - has invalid length
     * @throws \EnhancedCRM\Exception\ConfigurationError if provided base url is invalid
     *
     * @return boolean
     */
    public function validate()
    {
        if (!is_string($this->accessToken))
        {
            $msg = 'Provided access token is invalid as it is not a string';
            throw new Exception\ConfigurationError($msg);
        }

        if (preg_match('/\s/', $this->accessToken))
        {
            $msg = 'Provided access token is invalid '
                . 'as it contains disallowed chracters. '
                . 'Please double-check your access token.';
            throw new Exception\ConfigurationError($msg);
        }

        if (strlen($this->accessToken) != 64)
        {
            $msg = 'Provided access token is invalid '
                . 'as it does not match the required length. '
                . 'Please double-check your access token.';
            throw new Exception\ConfigurationError($msg);
        }

        if (!is_string($this->baseUrl) || !preg_match(Configuration::URL_REGEXP, $this->baseUrl))
        {
            $msg = 'Provided base url is invalid '
                . 'as it is not a valid URI. '
                . 'Please make sure it includes the schema part, both http and https are accepted, '
                . 'and the hierarchical part.';
            throw new Exception\ConfigurationError($msg);
        }

        return true;
    }

    /**
     * @ignore
     */
    protected function _accessTokenIsMissing()
    {
        $msg = 'No access token provided. '
            . 'Set your access token during client initialization using: '
            . '"new \\EnhancedCRM\\Client([\'accessToken\' => \'<YOUR_PERSONAL_ACCCESS_TOKEN\'])"';
        return $msg;
    }
}
