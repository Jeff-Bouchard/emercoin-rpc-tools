<?php

namespace azhuravlov\Emercoin\NVS;

use azhuravlov\Emercoin\Connection\Response\Response;
use PHPUnit\Framework\TestCase;

class DPOTest extends TestCase
{
    protected $response;
    /** @var Record */
    protected $record;

    protected function setUp()
    {
        $json = '{"name":"dpo:Your Company:DEMO-1005:0","value":"Item=Name of your product\nPhoto=http:\/\/www.blockchainengine.org\/wp-content\/uploads\/2016\/04\/Smart4.png\nDescription=The description of your product\nOTP=a7c3bc4b6fb066654164eb6dda4b70c9c3d4e28fdfecafd5b390f1a39cbd9856","txid":"424500e4368ad718c7c5395d322fc8cf3c5573ab32244b599f8cab4f478d9af7","address":"ERGPQNKpmJNaXeaq6ZDYwgghQDMBQGVema","expires_in":112249,"expires_at":343827,"time":1487961100}';
        $this->response = array('result' => json_decode($json, true));
        $this->record = new Record(new Response($this->response, array('http_code' => 200)));
    }

    public function testException()
    {
        $this->expectException(\LogicException::class);
        $this->record->setName('ssl:key');
        new DPO($this->record);
    }

    public function testHasSignature()
    {
        $dpo = new DPO($this->record);
        $this->assertFalse($dpo->hasSignature());
    }

    public function testMagicValueDecoding()
    {
        $dpo = new DPO($this->record);
        $this->assertEquals('Name of your product', $dpo->Item);
        $this->assertEquals('http://www.blockchainengine.org/wp-content/uploads/2016/04/Smart4.png', $dpo->Photo);
        $this->assertEquals('The description of your product', $dpo->Description);
        $this->assertEquals('a7c3bc4b6fb066654164eb6dda4b70c9c3d4e28fdfecafd5b390f1a39cbd9856', $dpo->OTP);
    }

    public function testGetData()
    {
        $dpo = new DPO($this->record);
        $expected = array(
            'Item' => 'Name of your product',
            'Photo' => 'http://www.blockchainengine.org/wp-content/uploads/2016/04/Smart4.png',
            'Description' => 'The description of your product',
            'OTP' => 'a7c3bc4b6fb066654164eb6dda4b70c9c3d4e28fdfecafd5b390f1a39cbd9856',
        );
        $this->assertArraySubset($expected, $dpo->getData());
    }
}
