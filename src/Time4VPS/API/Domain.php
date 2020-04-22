<?php

namespace Time4VPS\API;

use Time4VPS\Base\Endpoint;

class Domain extends Endpoint
{

    public function __construct()
    {
        parent::__construct('domain');
    }
}