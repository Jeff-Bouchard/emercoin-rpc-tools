<?php

namespace azhuravlov\Emercoin\NVS;

use azhuravlov\Emercoin\Connection\ConnectionInterface;

class DNS extends AbstractRecord
{
    /**
     * @var array
     */
    protected $records;

    /**
     * @param ConnectionInterface $connection
     * @param string $record
     */
    public function __construct(ConnectionInterface $connection, $record)
    {
        parent::__construct($connection, "dns:{$record}");

        $pairs = preg_split('/\||\n/', $this->getValue());

        foreach ($pairs as $val) {
            list($record, $value) = explode('=', $val, 2);
            if (strlen($record) > 0) {
                $this->records[strtoupper($record)][] = $value;
            }
        }
    }

    /**
     * @param null|string $record
     * @return array
     */
    public function find($record = null)
    {
        if ($record) {
            return $this->records[strtoupper($record)];
        }

        return $this->records;
    }

    /**
     * Alias for find method
     * @return array
     */
    public function findAll()
    {
        return $this->records;
    }
}
