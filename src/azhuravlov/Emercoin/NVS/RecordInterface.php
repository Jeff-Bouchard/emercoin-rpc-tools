<?php

namespace azhuravlov\Emercoin\NVS;

interface RecordInterface
{
    public function getName();

    public function getValue();

    public function getTxid();

    public function getAddress();

    public function getExpiresIn();

    public function getExpiresAt();

    public function getTime();
}