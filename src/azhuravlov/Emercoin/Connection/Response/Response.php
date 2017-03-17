<?php

namespace azhuravlov\Emercoin\Connection\Response;

use azhuravlov\Emercoin\Exception\TransportException;
use azhuravlov\Emercoin\NVS\Exception\RecordNotFoundException;

class Response implements ResponseInterface
{
    /** @var array */
    protected $content;
    /** @var array */
    protected $headers;

    /**
     * @param array $content
     * @param array $headers
     * @throws TransportException
     */
    public function __construct(array $content, array $headers)
    {
        $this->content = $content;
        $this->headers = $headers;

        if ($this->headers['http_code'] != 200) {
            switch($this->content['error']['code']) {
                case -4:
                    throw new RecordNotFoundException($this->content['error']['message'],  $this->content['error']['code']);
                default:
                    throw new TransportException(
                        ucfirst(
                            sprintf($this->content['error']['message'].', error code "%d"', $this->content['error']['code'])
                        )
                    );
            }
        }
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->content['result'];
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    final public function __toString()
    {
        return json_encode($this->getResult(), JSON_UNESCAPED_UNICODE);
    }
}
