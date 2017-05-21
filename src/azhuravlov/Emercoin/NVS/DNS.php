<?php

namespace azhuravlov\Emercoin\NVS;

class DNS extends NVSEntity
{
    /**
     * @var array
     */
    protected $records;

    /**
     * @param RecordInterface $record
     */
    public function __construct(RecordInterface $record)
    {
        $this->record = $record;
        $pairs = preg_split('/\||\n/', $this->record->getValue());
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
