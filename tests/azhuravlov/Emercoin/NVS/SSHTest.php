<?php

namespace azhuravlov\Emercoin\NVS;

use azhuravlov\Emercoin\Connection\Response\Response;
use PHPUnit\Framework\TestCase;

class SSHTest extends TestCase
{
    protected $response;
    /** @var Record */
    protected $record;

    protected function setUp()
    {
        $json = '{"name":"ssh:sv","value":"ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDDmmpGAkaP88+mO2+mwWA0a0mcukuE\/Gh74KlqY0fjmu3EGyAmFFsVbdEVSXzFg8q29zqDzY+GIAWjjugb4ivuwLlUj17xftYPv9RyWp6THat10huqrMxtOcy6imPm4bok2fTZfQXSM2sLpsgmM5tgkh8FCGqKJcisVJsoAGtSkFE3n7qwoWxY5bgHkILCNuVMJ7MMF\/T7SX8sJxdYc1hf3wuceJn0Li\/JXEvYaDPAzpdytf7GuBZ7cfu8Jw5VMvGCRrGcrXjn5eu4\/7YG773+n+THrDuqKPbRAWOubecSAp2pJnzP+uqknnnp3A\/yeHyITnR9jfOgHUv8iR225wnD sv@sv","txid":"748396b0abaebae8db3f8d00c03cd51a4a0d343f4defbd94c1b053974a072b41","address":"EP5Tx6iP9q8F7cC4aqFSicKjzoqzRrMMLF","expires_in":1669203,"expires_at":1900778,"time":1455615793}';
        $this->response = array('result' => json_decode($json, true));
        $this->record = new Record(new Response($this->response, array('http_code' => 200)));
    }

    public function testException()
    {
        $this->expectException(\LogicException::class);
        $this->record->setName('dpo:sv');
        new SSH($this->record);
    }

    public function testToString()
    {
        $ssh = new SSH($this->record);
        $this->assertEquals($this->response['result']['value'], $ssh->__toString());
    }
}