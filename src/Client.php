<?php

namespace EnhancedCRM;

use EnhancedCRM\Resource\Leads;
use EnhancedCRM\Resource\Offers;

/**
 * eCRM client that makes managing the resource easy.
 */
class Client
{
    /**
     * @var Http Http client
     */
    protected $http;

    /**
     * @var Configuration Client configuratation
     */
    public $config;

    /**
     * @var Resource\Leads Access all Leads related actions.
     */
    public $leads;

    /*
     * Instantiate a new BaseCRM API V2 client.
     * Client accepts an array of configuration options.
     *
     * Here's an example of creating a client with an access token:
     *
     *  $client = new \EnhancedCRM\Client(["accessToken" => "YOUR_PERSONAL_ACCESS_TOKEN"]);
     *
     * @param array $config Client configuration settings
     *    - accessToken: Personal access token
     *    - baseUrl: Base url for the api. Default: "https://api.getbase.com"
     *    - userAgent: Client user agent. Default: "BaseCRM/v2 PHP/{BaseCRM::VERSION}"
     *    - timeout: Request timeout. Default: 30 seconds
     *    - verifySSL: Whether to verify ssl or not. Default: true
     *    - verbose: Verbose/debug mode. Default: false
     *
     * @throws \EnhancedCRM\Errors\ConfigurationError if no access token provided
     * @throws \EnhancedCRM\Errors\ConfigurationError if provided access token is invalid - contains disallowed characters
     * @throws \EnhancedCRM\Errors\ConfigurationError if provided access token is invalid - has invalid length
     * @throws \EnhancedCRM\Errors\ConfigurationError if provided base url is invalid
     *
     */
    public function __construct(array $config = [])
    {
        $this->config = new Configuration($config);
        $this->http = new Http($this->config);

        // Resources
        $this->leads = new Leads($this->http);
        $this->offers = new Offers($this->http);
    }
}
