<?php

namespace Time4VPS\API;

use Time4VPS\Base\Endpoint;

class Servers extends Endpoint
{
    /**
     * Servers constructor.
     */
    public function __construct()
    {
        parent::__construct('server');
    }

    /**
     * Get all servers
     * @return array Available servers array
     * @throws \Time4VPS\Exceptions\APIException
     */
    public function all()
    {
        return $this->get();
    }

}