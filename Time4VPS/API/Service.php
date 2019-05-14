<?php

namespace Time4VPS\API;

use Time4VPS\Base\Endpoint;
use Time4VPS\Exceptions\APIException;
use Time4VPS\Exceptions\AuthException;
use Time4VPS\Exceptions\Exception;

class Service extends Endpoint
{
    /**
     * @var int Account ID
     */
    private $account_id;

    /**
     * Service constructor.
     * @param null $account_id
     * @throws Exception
     */
    public function __construct($account_id = null)
    {
        parent::__construct('service');
        if ($account_id) {
            $this->account_id = (int) $account_id;
            if ($this->account_id <= 0) {
                throw new Exception("Script ID '{$account_id}' is invalid");
            }
        }
    }

    /**
     * Get account details
     *
     * @return array
     * @throws APIException
     * @throws AuthException
     */
    public function details()
    {
        if (!$this->account_id) {
            throw new APIException('Account ID is not set');
        }

        return array_shift($this->get("/{$this->account_id}"));
    }

    /**
     * Get account ID from Order Number
     *
     * @param $order_num
     * @return int
     * @throws APIException
     * @throws AuthException
     */
    public function fromOrder($order_num)
    {
        $response = $this->get("/order/{$order_num}");

        return (int) $response['account_id'];
    }

    /**
     * Cancel / terminate account
     *
     * @param string $reason Termination reason
     * @param bool $immediate Immediate termination
     * @return array
     * @throws APIException
     * @throws AuthException
     */
    public function cancel($reason, $immediate = false)
    {
        return $this->post("/{$this->account_id}/cancel", [
            'immediate' => $immediate,
            'reason' => $reason
        ]);
    }
}