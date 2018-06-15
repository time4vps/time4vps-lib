<?php

namespace Time4VPS\API;

use Time4VPS\Base\Endpoint;

class Server extends Endpoint
{

    /**
     * @var int $server_id Server ID
     */
    private $server_id;

    /**
     * Server constructor.
     * @param $server_id
     */
    public function __construct($server_id)
    {
        parent::__construct('server');
        $this->server_id = $server_id;
    }

    /**
     * Get server details
     * @return array Server Details
     * @throws \Time4VPS\Exceptions\APIException
     */
    public function details()
    {
        return $this->get("{$this->server_id}");
    }

    /**
     * Reboot server
     * @return int Task ID
     * @throws \Time4VPS\Exceptions\APIException
     */
    public function reboot()
    {
        $response = $this->post("{$this->server_id}/reboot");
        return (int) $response['task_id'];
    }

    /**
     * Reinstall server
     * @param string $os OS code from available OS list
     * @return int Task ID
     * @throws \Time4VPS\Exceptions\APIException
     */
    public function reinstall($os)
    {
        $response = $this->post("{$this->server_id}/reinstall", [
            'os' => $os
        ]);

        return (int) $response['task_id'];
    }

    /**
     * Launch WebConsole
     * @param string $timeout 1h, 3h, 12h, etc.
     * @param bool $whitelabel Use whitelabel hostname for web based console
     * @return int Task ID
     * @throws \Time4VPS\Exceptions\APIException
     */
    public function webConsole($timeout = '1h', $whitelabel = true)
    {
        $response = $this->post("{$this->server_id}/webconsole", [
            'timeout' => $timeout,
            'whitelabel' => $whitelabel
        ]);

        return (int) $response['task_id'];
    }

    /**
     * Changes the hostname of your server. Hostname must pointed to your server main IP address.
     * @param string $hostname FQDN hostname pointed to main server IP address
     * @return int Task ID
     * @throws \Time4VPS\Exceptions\APIException
     */
    public function rename($hostname)
    {
        $response = $this->post("{$this->server_id}/rename", [
            'hostname' => $hostname
        ]);

        return (int) $response['task_id'];
    }

    /**
     * Password reset
     * @return int Task ID
     * @throws \Time4VPS\Exceptions\APIException
     */
    public function resetPassword()
    {
        $response = $this->post("{$this->server_id}/resetpassword");
        return (int) $response['task_id'];
    }

    /**
     * Changes PTR record for the additional IP (if server has more than one IPv4 address).
     * @param string $ip_address Additional IP address
     * @param string $hostname FQDN hostname pointed to additional IP address
     * @return int Task ID
     * @throws \Time4VPS\Exceptions\APIException
     */
    public function setPTR($ip_address, $hostname)
    {
        $response = $this->post("{$this->server_id}/changeptr", [
            'ip_address' => $ip_address,
            'hostname' => $hostname
        ]);

        return (int) $response['task_id'];
    }

    /**
     * Flush server firewall
     * @return int Task ID
     * @throws \Time4VPS\Exceptions\APIException
     */
    public function flushFirewall()
    {
        $response = $this->post("{$this->server_id}/flushfirewall");
        return (int) $response['task_id'];
    }

    /**
     * Change DNS servers
     * @param string $ns1 Nameserver 1 IP
     * @param string $ns2 Nameserver 2 IP
     * @param string $ns3 Nameserver 3 IP
     * @param string $ns4 Nameserver 4 IP
     * @return int Task ID
     * @throws \Time4VPS\Exceptions\APIException
     */
    public function setDNS($ns1, $ns2 = '', $ns3 = '', $ns4 = '')
    {
        $response = $this->post("{$this->server_id}/changedns", [
            'ns1' => $ns1,
            'ns2' => $ns2,
            'ns3' => $ns3,
            'ns4' => $ns4
        ]);

        return (int) $response['task_id'];
    }

    /**
     * Get available OS list for server
     * @return array OS List
     * @throws \Time4VPS\Exceptions\APIException
     */
    public function availableOS()
    {
        return $this->get("{$this->server_id}/oses");
    }

    /**
     * Server usage graphs
     * @return array Usage graph array
     * @throws \Time4VPS\Exceptions\APIException
     */
    public function usageGraphs()
    {
        return $this->get("{$this->server_id}/graphs");
    }

    /**
     * Server usage history
     * @return array Usage history array
     * @throws \Time4VPS\Exceptions\APIException
     */
    public function usageHistory()
    {
        return $this->get("{$this->server_id}/history");
    }

}