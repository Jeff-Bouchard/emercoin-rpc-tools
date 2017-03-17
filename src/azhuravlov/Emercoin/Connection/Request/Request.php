<?php

namespace azhuravlov\Emercoin\Connection\Request;

class Request implements RequestInterface
{
    /** @var string */
    protected $method;

    /** @var  string|array */
    protected $parameters;

    /**
     * @param string $method
     * @param array $parameters
     * @throws \InvalidArgumentException
     */
    public function __construct($method, $parameters = [])
    {
        if (!(is_array($parameters) || is_string($parameters))) {
            throw new \InvalidArgumentException(
                sprintf("Invalid parameter type. Must be array or string. Type %s given.", gettype($parameters))
            );
        }

        $this->method = $method;
        $this->parameters = is_string($parameters) ? [$parameters] : $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getJsonData($options = JSON_UNESCAPED_UNICODE, $depth = 512)
    {
        return json_encode(
            $this->getData(),
            $options,
            $depth
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return [
            'method' => $this->method,
            'params' => $this->parameters,
        ];
    }
}