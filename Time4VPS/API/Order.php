<?php

namespace Time4VPS\API;

use Time4VPS\Base\Endpoint;
use Time4VPS\Exceptions\APIException;
use Time4VPS\Exceptions\AuthException;

class Order extends Endpoint
{

    public function __construct()
    {
        parent::__construct('order');
    }

    /**
     * Order new product
     *
     * @param $product_id
     * @param null $domain
     * @return array
     * @throws APIException
     * @throws AuthException
     */
    public function new($product_id, $domain = null)
    {
        return $this->post("/{$product_id}", [
            'domain' => $domain
        ]);
    }
}