<?php

namespace azhuravlov\Emercoin\Connection\Request;


interface RequestInterface
{
    /**
     * @param int $options
     * @param int $depth
     * @return string
     */
    public function getJsonData($options = JSON_UNESCAPED_UNICODE, $depth = 512);

    /**
     * @return array
     */
    public function getData();
}