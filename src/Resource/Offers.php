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
     * Load order by uuid
     *
     * @param string $hash
     * @return mixed
     */
    public function load($hash)
    {
        return $this->http->request('GET', "/offer/{$hash}", null, null, ['raw' => true])->getResource();
    }

    /**
     * Notify crm about a completed offer order
     *
     * @param array $data
     * @return resource
     */
    public function notifyComplete(array $data)
    {
        return $this->http->request(
            'POST',
            "/offers/complete/{$data['offerId']}",
            null,
            $data,
            ['raw' => true]
        )->getResource();
    }

    /**
     * Send notification about opened offer
     *
     * @param $offerId
     * @return resource
     */
    public function notifyOpen($offerId)
    {
        return $this->http->request(
            'POST',
            "/offers/open/{$offerId}",
            null,
            null,
            ['raw' => true]
        )->getResource();
    }
}
