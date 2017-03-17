<?php

namespace azhuravlov\Emercoin\NVS;

use azhuravlov\Emercoin\Connection\ConnectionInterface;
use azhuravlov\Emercoin\NVS\Exception\RecordNotFoundException;

class SSL extends AbstractRecord
{
    protected $isAlias;

    public function __construct(ConnectionInterface $connection, $record)
    {
        try {
            parent::__construct($connection, "ssl:{$record}");
        } catch (RecordNotFoundException $e) {
            parent::__construct($connection, "ssh:{$record}");
            $this->isAlias = true;
        }
    }

    public function isAlias()
    {
        return $this->isAlias;
    }
}
