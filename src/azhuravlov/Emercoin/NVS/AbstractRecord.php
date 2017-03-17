<?php

namespace azhuravlov\Emercoin\NVS;

use azhuravlov\Emercoin\Connection\ConnectionInterface;

abstract class AbstractRecord implements RecordInterface
{
    /** @var ConnectionInterface */
    protected $connection;

    /** @var string */
    protected $name;

    /** @var string */
    protected $value;

    /** @var string */
    protected $txid;

    /** @var string */
    protected $address;

    /** @var integer */
    protected $expiresIn;

    /** @var integer */
    protected $expiresAt;

    /** @var */
    protected $time;

    /**
     * @param ConnectionInterface $connection
     * @param string $record
     */
    public function __construct(ConnectionInterface $connection, $record)
    {
        $this->connection = $connection;
        $response = $connection->query('name_show', $record);
        $data = $response->getResult();

        $this->name = $data['name'];
        $this->value = $data['value'];
        $this->txid = $data['txid'];
        $this->address = $data['address'];
        $this->expiresIn = $data['expires_in'];
        $this->expiresAt = $data['expires_at'];
        $this->time = $data['time'];
    }

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return new \DateTime($this->time);
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return integer
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return $this->expiresIn <= 0;
    }

    /**
     * @return integer
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTxid()
    {
        return $this->txid;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
