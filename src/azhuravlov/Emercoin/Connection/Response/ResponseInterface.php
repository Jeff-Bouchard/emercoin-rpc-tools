<?php
namespace azhuravlov\Emercoin\Connection\Response;

interface ResponseInterface
{
    public function getResult();

    public function getHeaders();
}
