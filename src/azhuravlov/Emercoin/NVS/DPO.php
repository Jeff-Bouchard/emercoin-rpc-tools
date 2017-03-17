<?php

namespace azhuravlov\Emercoin\NVS;

use azhuravlov\Emercoin\Connection\ConnectionInterface;

class DPO extends AbstractRecord
{
    /** @var array */
    protected $data;

    /**
     * @param ConnectionInterface $connection
     * @param string $record
     */
    public function __construct(ConnectionInterface $connection, $record)
    {
        parent::__construct($connection, "dpo:{$record}");

        foreach (explode("\n", utf8_decode($this->value)) as $row) {
            list($k, $value) = explode('=', $row, 2);
            if (strlen($k) > 0) {
                $this->data[$k] = $value;
            }
        }
    }

    /**
     * @return bool
     */
    public function hasSignature()
    {
        return in_array('Signature', $this->data);
    }

    /**
     * @return null|string
     */
    public function getSignature()
    {
        if ($this->hasSignature()) {
            return $this->data['Signature'];
        }

        return null;
    }

    public function __get($property)
    {
        if (array_key_exists($property, $this->data)) {
            return $this->data[$property];
        }

        return null;
    }

    public function __set($property, $value)
    {
        // nothing to do, just forbid to change dynamic properties
    }

    public function getData()
    {
        return $this->data;
    }
}
