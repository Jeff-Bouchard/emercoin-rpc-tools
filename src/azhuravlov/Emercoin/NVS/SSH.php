<?php

namespace azhuravlov\Emercoin\NVS;

class SSH extends NVSEntity
{
    public function __construct(RecordInterface $record)
    {
        list($type) = explode(':', $record->getName());

        if ($type !== 'ssh') {
            throw new \LogicException(sprintf("Expected record type \"ssh\", but got \"%s\"", $type));
        }

        $this->record = $record;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->record->getValue();
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
