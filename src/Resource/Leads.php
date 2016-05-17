<?php

namespace EnhancedCRM\Resource;

use EnhancedCRM\Http;

/**
 * Leads
 *
 * Class used to make actions related to Lead resource.
 */
class Leads
{
    /**
     * @var array
     */
    protected static $validStructure = [
        'title' => true,
        'description' => true,
        'price' => true,
        'contacts' => [[
            'firstName' => true,
            'lastName' => true,
            'companyName' => true,
            'phones' => [[
                'phone' => true
            ]],
            'emails' => [[
                'email' => true
            ]],
        ]],
        'metas' => [],
    ];

    /**
     * @var Http
     */
    protected $http;

    /**
     * Instantiate a new LeadsService instance.
     *
     * @param Http $http Http client.
     */
    public function __construct(Http $http)
    {
        $this->http = $http;
    }

    /**
     * Creates new lead.
     *
     * @param array $lead Lead object attributes.
     *
     * @return array Created lead object.
     */
    public function create(array $lead)
    {
        $this->validateArray($lead, self::$validStructure);
        $attributes = [ 'lead' => $lead ];

        return $this->http->post("/leads", $attributes, ['raw' => true])->getResource();
    }

    /**
     * @param array $input
     * @param array $structure
     *
     * @return bool
     */
    protected function validateArray(&$input, $structure)
    {
        foreach ($input as $key => &$value) {
            if (is_array($value)) {
                $this->validateArray($value, $structure[$key]);
            }
        }

        foreach ($input as $key => $item) {
            if (!isset($structure[$key])) {
                unset($input[$key]);
            }
        }
    }
}
