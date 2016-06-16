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
        'message' => true,
        'description' => true,
        'price' => true,
        'contacts' => [[
            'title' => true,
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
        'source' => true,
        'sourceUrl' => true,
        'orderId' => true,
        'orderStatus' => true,
        'metas' => [],
    ];

    /**
     * @var Http
     */
    protected $http;

    /**
     * @var array
     */
    protected $lead = [];

    /**
     * @var int
     */
    protected $leadId;

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
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->leadId = $id;

        return $this;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->lead['title'] = $title;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->lead['message'] = $message;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->lead['description'] = $description;

        return $this;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setContactTitle($title)
    {
        $this->lead['contacts'][0]['title'] = $title;

        return $this;
    }

    /**
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->lead['contacts'][0]['firstName'] = $firstName;

        return $this;
    }

    /**
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lead['contacts'][0]['lastName'] = $lastName;

        return $this;
    }

    /**
     * @param string $companyName
     *
     * @return $this
     */
    public function setCompanyName($companyName)
    {
        $this->lead['contacts'][0]['companyName'] = $companyName;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->lead['contacts'][0]['emails'][0] = ['email' => $email];

        return $this;
    }

    /**
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->lead['contacts'][0]['phones'][0] = ['phone' => $phone];

        return $this;
    }

    /**
     * @param string $price
     *
     * @return $this
     */
    public function setPrice($price)
    {
        $this->lead['price'] = $price;

        return $this;
    }

    /**
     * @param string $source
     *
     * @return $this
     */
    public function setSource($source)
    {
        $this->lead['source'] = $source;

        return $this;
    }

    /**
     * @param string $sourceUrl
     *
     * @return $this
     */
    public function setSourceUrl($sourceUrl)
    {
        $this->lead['sourceUrl'] = $sourceUrl;

        return $this;
    }

    /**
     * @param string $orderId
     *
     * @return $this
     */
    public function setOrderId($orderId)
    {
        $this->lead['orderId'] = $orderId;

        return $this;
    }

    /**
     * @param string $orderStatus
     *
     * @return $this
     */
    public function setOrderStatus($orderStatus)
    {
        $this->lead['orderStatus'] = $orderStatus;

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function setMetadata($key, $value)
    {
        $this->lead['metas'][] = ['key' => $key, 'value' => $value];

        return $this;
    }

    /**
     * @return $this
     */
    public function refresh()
    {
        $this->leadId = null;
        $this->lead = [];

        return $this;
    }

    /**
     * Creates new lead.
     *
     * @return array Created lead object.
     */
    public function send()
    {
        $this->validateArray($this->lead, self::$validStructure);

        $body = [ 'lead' => $this->lead ];

        $method = $this->leadId ? 'PATCH' : 'POST';
        $url = $this->leadId ? "/leads/{$this->leadId}" : '/leads';

        return $this->http->request($method, $url, null, $body, ['raw' => true])->getResource();
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
