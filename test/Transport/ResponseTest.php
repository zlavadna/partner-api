<?php

namespace ZlavaDna\Transport;

class ResponseTest extends \PHPUnit_Framework_TestCase {

    public function testsetResponseDataInvalidJson() {
        $response = new Response();
        $response->setResponseData('invalid-json');
        $this->assertFalse($response->getResult());
        $this->assertEquals(0, $response->getErrorCode());
        $this->assertNull($response->getData());
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testsetResponseDataValidJsonInvalidStructure() {
        $response = new Response();
        $response->setResponseData('{"valid": "json"}');
    }

    public function testsetResponseDataPositiveResult() {
        $response = new Response();
        $response->setResponseData('{"result":true}');
        $this->assertTrue($response->getResult());
    }

    public function testsetResponseDataNegativeResult() {
        $response = new Response();
        $response->setResponseData('{"result":false}');
        $this->assertFalse($response->getResult());
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testsetResponseDataNonBooleanResult() {
        $response = new Response();
        $response->setResponseData('{"result":"non boolean"}');
    }

    public function testGetDataNoData() {
        $response = new Response();
        $response->setResponseData('{"result":true}');
        $this->assertNull($response->getData());
        $response = new Response();
        $response->setResponseData('{"result":true, "data": []}');
        $this->assertNull($response->getData());
        $response = new Response();
        $response->setResponseData('{"result":true, "data": ""}');
        $this->assertNull($response->getData());
    }

    public function testGetDataSomeData() {
        $response = new Response();
        $response->setResponseData('{"result":true, "data": "some data"}');
        $this->assertEquals('some data', $response->getData());
    }

    public function testGetErrorCodeNoData() {
        $response = new Response();
        $response->setResponseData('{"result":true}');
        $this->assertNull($response->getErrorCode());
    }

    public function testGetErrorCodeValidData() {
        $response = new Response();
        $response->setResponseData('{"result":true, "error": {"code": "10"}}');
        $this->assertEquals(10, $response->getErrorCode());
        $this->assertInternalType('integer', $response->getErrorCode());
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testGetErrorCodeInvalidData() {
        $response = new Response();
        $response->setResponseData('{"result":true, "error": {"code": "non numeric"}}');
    }

    public function testGetErrorMessageNoData() {
        $response = new Response();
        $response->setResponseData('{"result":true}');
        $this->assertNull($response->getErrorMessage());
    }

    public function testGetErrorMessageValidData() {
        $response = new Response();
        $response->setResponseData('{"result":true, "error": {"message": "some message"}}');
        $this->assertEquals('some message', $response->getErrorMessage());
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testGetErrorMessageInvalidData() {
        $response = new Response();
        $response->setResponseData('{"result":true, "error": {"message": 10}}');
    }

}