<?php

namespace azhuravlov\Emercoin\NVS;

use azhuravlov\Emercoin\Connection\Response\Response;
use PHPUnit\Framework\TestCase;

class RecordTest extends TestCase
{
    protected $response;
    /** @var Record */
    protected $record;

    public function setUp()
    {
        $json = '{"name":"ssh:sv","value":"ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDDmmpGAkaP88+mO2+mwWA0a0mcukuE\/Gh74KlqY0fjmu3EGyAmFFsVbdEVSXzFg8q29zqDzY+GIAWjjugb4ivuwLlUj17xftYPv9RyWp6THat10huqrMxtOcy6imPm4bok2fTZfQXSM2sLpsgmM5tgkh8FCGqKJcisVJsoAGtSkFE3n7qwoWxY5bgHkILCNuVMJ7MMF\/T7SX8sJxdYc1hf3wuceJn0Li\/JXEvYaDPAzpdytf7GuBZ7cfu8Jw5VMvGCRrGcrXjn5eu4\/7YG773+n+THrDuqKPbRAWOubecSAp2pJnzP+uqknnnp3A\/yeHyITnR9jfOgHUv8iR225wnD sv@sv","txid":"748396b0abaebae8db3f8d00c03cd51a4a0d343f4defbd94c1b053974a072b41","address":"EP5Tx6iP9q8F7cC4aqFSicKjzoqzRrMMLF","expires_in":1669203,"expires_at":1900778,"time":1455615793}';
        $this->response = array('result' => json_decode($json, true));
        /** @var Record record */
        $this->record = new Record(new Response($this->response, array('http_code' => 200)));
    }

    public function testEmptyRecord()
    {
        $record = new Record();

        $this->assertNull($record->getName());
    }

    public function testConstructor()
    {
        $this->assertEquals('ssh:sv', $this->record->getName());
        $this->record->setName('ssh:azhuravlov');
        $this->assertEquals('ssh:azhuravlov', $this->record->getName());
        $this->assertEquals(
            'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDDmmpGAkaP88+mO2+mwWA0a0mcukuE/Gh74KlqY0fjmu3EGyAmFFsVbdEVSXzFg8q29zqDzY+GIAWjjugb4ivuwLlUj17xftYPv9RyWp6THat10huqrMxtOcy6imPm4bok2fTZfQXSM2sLpsgmM5tgkh8FCGqKJcisVJsoAGtSkFE3n7qwoWxY5bgHkILCNuVMJ7MMF/T7SX8sJxdYc1hf3wuceJn0Li/JXEvYaDPAzpdytf7GuBZ7cfu8Jw5VMvGCRrGcrXjn5eu4/7YG773+n+THrDuqKPbRAWOubecSAp2pJnzP+uqknnnp3A/yeHyITnR9jfOgHUv8iR225wnD sv@sv',
            $this->record->getValue()
        );
        $this->record->setValue('custom value');
        $this->assertEquals('custom value', $this->record->getValue());
        $this->assertEquals('EP5Tx6iP9q8F7cC4aqFSicKjzoqzRrMMLF', $this->record->getAddress());
        $this->assertEquals(
            '748396b0abaebae8db3f8d00c03cd51a4a0d343f4defbd94c1b053974a072b41',
            $this->record->getTxid()
        );
        $this->assertEquals('1900778', $this->record->getExpiresAt());
        $this->assertEquals('1669203', $this->record->getExpiresIn());
        $this->assertEquals('1455615793', $this->record->getTime());
    }

    public function testIsExpired()
    {
        $this->assertFalse($this->record->isExpired());
    }
}
