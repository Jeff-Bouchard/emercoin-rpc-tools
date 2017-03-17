<?php

namespace azhuravlov\Emercoin\NVS;

use azhuravlov\Emercoin\Connection\ConnectionInterface;

class SSH extends AbstractRecord
{
    public function __construct(ConnectionInterface $connection, $record)
    {
        parent::__construct($connection, "ssh:{$record}");
    }
}
