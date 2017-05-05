<?php

/**
 * @copyright C UAB NFQ Technologies 2016
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 */

namespace EnhancedCRM\Resource;

use EnhancedCRM\Http;

class Offers
{
    /**
     * @var Http
     */
    protected $http;

    /**
     * Instantiate a new offers service instance.
     *
     * @param Http $http Http client.
     */
    public function __construct(Http $http)
    {
        $this->http = $http;
    }

    /**
     * Load order by id
     *
     * @param string $id
     *
     * @return mixed
     */
    public function load($id)
    {
        return $this->http->request('GET', "/offers/{$id}", null, null, ['raw' => true])->getResource();
    }

    /**
     * Notify crm about a completed offer order
     *
     * @param string $id
     * @param array  $data
     *
     * @return resource
     */
    public function notifyComplete($id, array $data)
    {
        return $this->http->request(
            'POST',
            "/offers/{$id}/complete",
            null,
            $data,
            ['raw' => true]
        )->getResource();
    }
}
