<?php

namespace azhuravlov\Emercoin\Connection;

use azhuravlov\Emercoin\Exception\TransportException;
use azhuravlov\Emercoin\Connection\Response\Response;

interface ConnectionInterface
{
    public function getProtocol();

    public function getHost();

    public function getPort();

    public function getPassword();

    public function getUsername();

    public function getDsn();

    /**
     * @param string $name
     * @param string|array $params
     * @return Response
     * @throws TransportException
     */
    public function query($name, $params);
}