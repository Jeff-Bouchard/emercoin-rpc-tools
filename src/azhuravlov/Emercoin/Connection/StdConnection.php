<?php

namespace azhuravlov\Emercoin\Connection;

use azhuravlov\Emercoin\Exception\TransportException;
use azhuravlov\Emercoin\Connection\Request\Request;
use azhuravlov\Emercoin\Connection\Response\Response;

class StdConnection extends AbstractConnection
{
    /** @var bool */
    protected $ssl_verify_peer = false;
    /** @var bool */
    protected $ssl_verify_peer_name = false;
    /** @var int */
    protected $timeout = 10;

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSslVerifyPeer()
    {
        return $this->ssl_verify_peer;
    }

    /**
     * @param boolean $ssl_verify_peer
     * @return $this
     */
    public function setSslVerifyPeer($ssl_verify_peer)
    {
        $this->ssl_verify_peer = $ssl_verify_peer;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSslVerifyPeerName()
    {
        return $this->ssl_verify_peer_name;
    }

    /**
     * @param boolean $ssl_verify_peer_name
     * @return $this
     */
    public function setSslVerifyPeerName($ssl_verify_peer_name)
    {
        $this->ssl_verify_peer_name = $ssl_verify_peer_name;

        return $this;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws TransportException
     */
    protected function run(Request $request)
    {
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => join(
                    "\r\n",
                    [
                        'Content-Type: application/json; charset=utf-8',
                        'Accept-Charset: utf-8;q=0.7,*;q=0.7',
                    ]
                ),
                'content' => $request->getJsonData(),
                'ignore_errors' => true,
                'timeout' => $this->timeout,
            ],
            'ssl' => [
                "verify_peer" => $this->ssl_verify_peer,
                "verify_peer_name" => $this->ssl_verify_peer_name,
            ],
        ];

        $http_response_header = [];
        $response = @file_get_contents($this->getDsn(), false, stream_context_create($opts));

        if (!$response) {
            throw new TransportException('Something happened during sending request.');
        }

        $headers = array();

        foreach ($http_response_header as $k => $v) {
            $t = explode(':', $v, 2);
            if (isset($t[1])) {
                $headers[trim(strtolower($t[0]))] = trim($t[1]);
            } else {
                $headers[] = $v;
                if (preg_match('#HTTP/[0-9\.]+\s+([0-9]+)#', $v, $out)) {
                    $headers['http_code'] = intval($out[1]);
                }
            }
        }

        return new Response(json_decode($response, true), $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function query($name, $params = [])
    {
        $request = new Request($name, $params);

        return $this->run($request);
    }
}
