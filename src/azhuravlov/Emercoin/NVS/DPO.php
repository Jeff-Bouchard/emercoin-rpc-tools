<?php

namespace azhuravlov\Emercoin\NVS;

class DPO extends NVSEntity
{
    /** @var array */
    protected $data = [];

    /**
     * @param RecordInterface $record
     */
    public function __construct(RecordInterface $record = null)
    {
        if ($record) {
            list($type) = explode(':', $record->getName());
            if ($type !== 'dpo') {
                throw new \LogicException(sprintf("Expected record type \"dpo\", but got \"%s\"", $type));
            }

            $this->record = $record;

            foreach (explode("\n", utf8_decode($this->record->getValue())) as $row) {
                list($key, $value) = explode('=', $row, 2);
                if (strlen($key) > 0) {
                    $this->data[$key] = $value;
                }
            }
        }
    }

    /**
     * @return bool
     */
    public function hasSignature()
    {
        return in_array('Signature', $this->data);
    }

    /**
     * @return null|string
     */
    public function getSignature()
    {
        if ($this->hasSignature()) {
            return $this->data['Signature'];
        }

        return null;
    }

    public function __get($property)
    {
        if (array_key_exists($property, $this->data)) {
            return $this->data[$property];
        }

        return null;
    }

    public function __set($property, $value)
    {
        // nothing to do, just forbid to change dynamic properties
    }

    public function getData()
    {
        return $this->data;
    }

    public function set($field, $value)
    {
        if (!is_string($field)) {
            throw new \LogicException(sprintf('Expected $field type "string", but got "%s"', gettype($field)));
        }

        if (!is_string($value)) {
            throw new \LogicException(sprintf('Expected $value type "string", but got "%s"', gettype($value)));
        }

        $this->data[$field] = $value;
    }

    public function get($field)
    {
        if (!is_string($field)) {
            throw new \LogicException(sprintf('Expected $field type "string", but got "%s"', gettype($field)));
        }

        return $this->data[$field];
    }
}
