<?php

namespace azhuravlov\Emercoin\Manager\DPO;

use azhuravlov\Emercoin\Connection\ConnectionInterface;
use azhuravlov\Emercoin\Manager\DPO\Configuration\ProductConfig;
use azhuravlov\Emercoin\NVS\DPO;

class Product extends DPO
{
    const ADDRESS = 'address';
    const SIGNATURE = 'signature';

    protected $productConfig;
    /** @var array */
    protected $history = [];
    /** @var bool */
    protected $verified = false;
    /** @var string */
    protected $verifiedBy;

    /**
     * @param ConnectionInterface $connection
     * @param string $record
     * @param ProductConfig $productConfig
     */
    public function __construct(ConnectionInterface $connection, $record, ProductConfig $productConfig)
    {
        parent::__construct($connection, $record);
        $this->history = $this->connection->query('name_history', $this->getName())->getResult()[0];
        $this->productConfig = $productConfig;
    }

    /**
     * @return string
     */
    public function getHistoryAddress()
    {
        return $this->history['address'];
    }

    public function isVerified()
    {
        return $this->verified;
    }

    public function setVerified($verified)
    {
        $this->verified = $verified;

        return $this;
    }

    /**
     * @return string
     */
    public function getVerifiedBy()
    {
        return $this->verifiedBy;
    }

    /**
     * @param string $verifiedBy
     */
    public function setVerifiedBy($verifiedBy)
    {
        $this->verifiedBy = $verifiedBy;
    }

    public function verifyData()
    {
        $values = [$this->getName()];
        foreach ($this->data as $key => $value) {
            if (0 === strpos($key, 'F-')) {
                $values[] = $key.'='.$value;
            }
        }

        return join('|', $values);
    }
}
