<?php

namespace ZlavaDna\Transport;

class TransportTest extends \PHPUnit_Framework_TestCase {

    /**
     * Creates mock of Transport class.
     * @return Transport
     */
    private function getTransportMock() {

        return $this
            ->getMockBuilder('ZlavaDna\Transport\Transport')
            ->setMethods(array('doRequest', 'checkHttps'))
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testRequestInvalidUrl() {
        $this->getTransportMock()->request('invalid url');
    }

    public function testRequestHttp() {
        $transport = $this->getTransportMock();
        $transport->expects($this->never())->method('checkHttps');
        $transport->request('http://example.com');
    }

    public function testRequestHttps() {
        $transport = $this->getTransportMock();
        $transport->expects($this->once())->method('checkHttps');
        $transport->request('https://example.com');
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testRequestInvalidMethod() {
        $this->getTransportMock()->request('http://example.com', array(), 'PUT');
    }

    public function testRequestMethodGet() {
        $transport = $this->getTransportMock();
        $transport->expects($this->once())->method('doRequest')
            ->with($this->equalTo('http://example.com'), $this->callback(function($httpOptions) {
                return $httpOptions['method'] === 'GET' && strpos($httpOptions['header'], 'json') !== FALSE;
            }));
        $transport->request('http://example.com', array(), 'GET');
    }

    public function testRequestMethodPost() {
        $transport = $this->getTransportMock();
        $transport->expects($this->once())->method('doRequest')
            ->with($this->equalTo('http://example.com'), $this->callback(function($httpOptions) {
                return $httpOptions['method'] === 'POST' && strpos($httpOptions['header'], 'json') !== FALSE;
            }));
        $transport->request('http://example.com', array(), 'POST');
    }

    public function testRequestData() {
        $data = array('test1' => 'data1', 'test2' => 'data2');
        $transport = $this->getTransportMock();
        $transport->expects($this->once())->method('doRequest')
            ->with($this->equalTo('http://example.com'), $this->callback(function($httpOptions) use($data) {
                return $httpOptions['content'] = http_build_query($data);
            }));
        $transport->request('http://example.com', $data);
    }

    public function testRequestTimeout() {
        $transport = $this->getTransportMock();
        $transport->expects($this->once())->method('doRequest')
            ->with($this->equalTo('http://example.com'), $this->callback(function($httpOptions) {
                return $httpOptions['timeout'] === 100;
            }));
        $transport->request('http://example.com', array(), 'GET', array('timeout' => 100));
    }

}