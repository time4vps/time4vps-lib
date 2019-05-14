<?php

namespace Time4VPS\Base;

use Time4VPS\Exceptions\Exception;

class Endpoint
{
    /**
     * @var string API Endpoint Path
     */
    private $endpoint;

    /**
     * @var string Base API Url
     */
    private static $base_url;

    /**
     * @var string API Username
     */
    private static $api_username;

    /**
     * @var string API Password
     */
    private static $api_password;

    /**
     * @var callable Debug function
     */
    private static $debug_function;

    /**
     * Endpoint constructor.
     * @param $endpoint
     * @throws Exception
     */
    protected function __construct($endpoint)
    {
        if (!isset(self::$base_url)) {
            throw new Exception('API Endpoint Error: Base URL is not set');
        }

        if (!isset(self::$api_username) || !isset(self::$api_password)) {
            throw new Exception('API Endpoint Error: Credentials are not set');
        }

        $this->endpoint = trim($endpoint, '/');
    }

    /**
     * Base API Url
     *
     * @param $url
     */
    public static function BaseURL($url)
    {
        self::$base_url = $url;
    }

    /**
     * Set auth details
     *
     * @param $username
     * @param $password
     */
    public static function Auth($username, $password)
    {
        self::$api_username = $username;
        self::$api_password = $password;
    }

    /**
     * Set debug function
     *
     * @param $function
     */
    public static function DebugFunction($function) {
        self::$debug_function = $function;
    }

    /**
     * @param string $path API relative path
     * @return array
     */
    public function get($path = "") {
        return $this->request('GET', $path);
    }

    /**
     * @param string $path API relative path
     * @param array $data Post Data
     * @return array
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
     * @param callable $logFunction For debug purposes
     * @return array
     */
    public function request($method, $path, $data = [], $logFunction = null){

        $url = "{$this->endpoint}{$path}";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "utf-8",
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_USERPWD => self::$api_username . ':' . self::$api_password,
            CURLOPT_POSTFIELDS => $data
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        return $response;
    }
}