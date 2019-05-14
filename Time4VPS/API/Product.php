<?php

namespace Time4VPS\API;

use Time4VPS\Base\Endpoint;
use Time4VPS\Exceptions\APIException;
use Time4VPS\Exceptions\AuthException;
use Time4VPS\Exceptions\Exception;

class Product extends Endpoint
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct('category');
    }

    /**
     * Get available VPS servers
     *
     * @return array
     * @throws APIException
     * @throws AuthException
     */
    public function getAvailableVPS()
    {
        return $this->get('/available/vps');
    }
}