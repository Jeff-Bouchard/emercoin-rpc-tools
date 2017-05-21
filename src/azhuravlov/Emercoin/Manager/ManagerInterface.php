<?php

namespace azhuravlov\Emercoin\Manager;

use azhuravlov\Emercoin\Exception\TransportException;
use azhuravlov\Emercoin\NVS\Record;
use azhuravlov\Emercoin\NVS\RecordInterface;

interface ManagerInterface
{
    /**
     * @param string $record
     * @return Record|null
     */
    public function get($record);

    /**
     * @param string $record
     * @return Record|null
     */
    public function find($record);

    /**
     * @param RecordInterface $record
     * @param int $days
     * @param null|string $toAddress
     * @throws TransportException
     */
    public function persist(RecordInterface $record, $days = 3650, $toAddress = null);

    /**
     * @param RecordInterface $record
     * @throws TransportException
     */
    public function remove(RecordInterface $record);
}
