<?php

namespace azhuravlov\Emercoin\NVS;


abstract class NVSEntity
{
    /** @var RecordInterface */
    protected $record;

    /**
     * @return RecordInterface
     */
    public function getRecord()
    {
        return $this->record;
    }
}