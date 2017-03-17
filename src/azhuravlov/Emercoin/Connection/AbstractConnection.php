<?php

namespace azhuravlov\Emercoin\Connection;

abstract class AbstractConnection implements ConnectionInterface
{
    /** @var string */
    protected $protocol;
    /** @var string */
    protected $username;
    /** @var string */
    protected $password;
    /** @var string */
    protected $host;
    /** @var int */
    protected $port;

    /**
     * @param string $username
     * @param string $password
     * @param string $host
     * @param string $protocol
     * @param int $port
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function __construct($username, $password, $host = '127.0.0.1', $protocol = 'https', $port = 6662)
    {
        if (!in_array($protocol, ['https', 'http'])) {
            throw new \InvalidArgumentException(
                sprintf('Unsupported protocol, expected an "http" or "https", but got "%s".', $protocol)
            );
        }

        if ($port > 65535 || $port < 1) {
            throw new \OutOfRangeException(sprintf('Given port number is invalid, got "%s".', $port));
        }

        $this->username = $username;
        $this->password = $password;
        $this->host = $host;
        $this->protocol = $protocol;
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getDsn()
    {
        return $this->protocol.'://'.$this->username.':'.$this->password.'@'.$this->host.':'.$this->port;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}
