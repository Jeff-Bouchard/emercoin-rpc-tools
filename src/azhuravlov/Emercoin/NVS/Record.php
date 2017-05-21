<?php

namespace azhuravlov\Emercoin\NVS;

use azhuravlov\Emercoin\Connection\Response\Response;

class Record implements RecordInterface
{
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

    /** @var integer */
    protected $time;

    public function __construct(Response $response = null)
    {
        if ($response) {
            $data = $response->getResult();

            $this->name = $data['name'];
            $this->value = $data['value'];
            $this->txid = $data['txid'];
            $this->address = $data['address'];
            $this->expiresIn = $data['expires_in'];
            $this->expiresAt = $data['expires_at'];
            $this->time = $data['time'];
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getTxid()
    {
        return $this->txid;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function isExpired()
    {
        return $this->expiresIn < 0;
    }

    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    public function getTime()
    {
        return $this->time;
    }
}