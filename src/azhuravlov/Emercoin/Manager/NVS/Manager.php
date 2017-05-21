<?php

namespace azhuravlov\Emercoin\Manager\NVS;

use azhuravlov\Emercoin\Connection\ConnectionInterface;
use azhuravlov\Emercoin\Manager\ManagerInterface;
use azhuravlov\Emercoin\NVS\Exception\RecordNotFoundException;
use azhuravlov\Emercoin\NVS\Record;
use azhuravlov\Emercoin\NVS\RecordInterface;

class Manager implements ManagerInterface
{
    /** @var ConnectionInterface */
    protected $connection;

    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function get($record)
    {
        return $this->find($record);
    }

    /**
     * {@inheritdoc}
     */
    public function find($record)
    {
        try {
            $response = $this->connection->query('name_show', $record);

            return new Record($response);
        } catch (RecordNotFoundException $e) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function persist(RecordInterface $record, $days = 3650, $toAddress = null)
    {
        $data = [
            $record->getName(),
            $record->getValue(),
            $days,
        ];

        if ($toAddress) {
            array_push($data, $toAddress);
        }

        $this->connection->query(
            ($record->getTxid() ? 'name_update' : 'name_new'),
            $data
        );
    }

    public function remove(RecordInterface $record)
    {
        $this->connection->query('name_delete', $record->getName());
    }
}
