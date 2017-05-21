<?php

namespace azhuravlov\Emercoin\NVS;

interface RecordInterface
{
    /** @return string */
    public function getName();

    /**
     * @param $name
     * @return RecordInterface
     */
    public function setName($name);

    /** @return string */
    public function getValue();

    /**
     * @param $value
     * @return RecordInterface
     */
    public function setValue($value);

    /** @return string */
    public function getTxid();

    /** @return string */
    public function getAddress();

    /** @return int */
    public function getExpiresIn();

    /** @return int */
    public function getExpiresAt();

    /** @return \DateTime */
    public function getTime();
}
