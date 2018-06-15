<?php

namespace Time4VPS\Base;

use GuzzleHttp\Exception\GuzzleException;
use Time4VPS\Exceptions\APIException;

abstract class Endpoint
{
    /**
     * @var string API Endpoint URL
     */
    private $url = 'https://billing.time4vps.eu/api/';

    /**
     * @var string API Endpoint path
     */
    private $endpoint = '';

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function __construct($endpoint)
    {
        $this->client = new \GuzzleHttp\Client();

        $endpoint = trim($endpoint, '/');
        $this->endpoint = "{$this->url}{$endpoint}";
    }

    /**
     * @param string $path API relative path
     * @return array
     * @throws APIException
     */
    public function get($path = "") {
        return $this->request('GET', $path);
    }

    /**
     * @param string $path API relative path
     * @param array $data Post Data
     * @return array
     * @throws APIException
     */
    public function post($path = "", $data = []) {
        return $this->request('POST', $path, $data);
    }

    /**
     * GET method
     *
     * @param string $method GET, POST, PUT, DELETE
     * @param string $path API relative path
     * @param array $data Post Data
     * @return array
     * @throws APIException
     */
    public function request($method, $path, $data = []){
        try {
            $request = $this->client->request($method, "{$this->endpoint}/{$path}", $data);
            $response = json_decode($request->getBody(), true);

            if (!$response) {
                throw new APIException('Invalid JSON received');
            }

            if (array_key_exists('error', $response)) {
                throw new APIException('Error: ' . $response['error']);
            }

            return $response;

        } catch (GuzzleException $e) {
            throw new APIException('HTTP Client error: ' . $e->getMessage());
        }
    }
}