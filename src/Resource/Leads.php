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
    protected static $validFields = [
        'address',
        'custom_fields',
        'description',
        'email',
        'facebook',
        'fax',
        'first_name',
        'industry',
        'last_name',
        'linkedin',
        'mobile',
        'organization_name',
        'owner_id',
        'phone',
        'skype',
        'source_id',
        'status',
        'tags',
        'title',
        'twitter',
        'website'
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
        $attributes = array_intersect_key($lead, array_flip(self::$validFields));

        if (isset($attributes['meta']) && empty($attributes['meta'])) unset($attributes['meta']);

        return $this->http->post("/leads", $attributes)->getResource();
    }
}
