<?php

namespace azhuravlov\Emercoin\NVS;

class SSL extends NVSEntity
{
    public function __construct(RecordInterface $record)
    {
        $this->record = $record;
    }

    public function getValue()
    {
        return $this->record->getValue();
    }
}
