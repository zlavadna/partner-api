<?php

namespace ZlavaDna;

use ZlavaDna\Transport\Transport;

class ApiTest extends \PHPUnit_Framework_TestCase {

    /**
     * Creates mock of Transport class.
     * @return Transport
     */
    private function getTransportMock() {

        return $this
            ->getMockBuilder('ZlavaDna\Transport\Transport')
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getDataCallback($partnerCode, $action, $code, $secret = NULL) {
        return function($data) use ($partnerCode, $action, $code, $secret) {

            return $data['partnerCode'] === $partnerCode && $data['action'] === $action && $data['code'] = $code && (empty($secret) || $data['password'] === $secret);
        };
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testConstructInvalidURL() {
        new Api('invalid url', '6f1ed002ab5595859014ebf0951522d9', $this->getTransportMock());
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testConstructInvalidPartnerCode() {
        new Api('http://example.com', 'invalid partner code', $this->getTransportMock());
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testQueryCouponWithoutCode() {
        $api = new Api('http://example.com', '6f1ed002ab5595859014ebf0951522d9', $this->getTransportMock());
        $api->queryCoupon('');
    }

    public function testQueryCouponWithoutSecret() {
        $transport = $this->getTransportMock();
        $transport
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('http://example.com'), $this->callback($this->getDataCallback('6f1ed002ab5595859014ebf0951522d9', 'queryCoupon', '123456789')));
        $api = new Api('http://example.com', '6f1ed002ab5595859014ebf0951522d9', $transport);
        $api->queryCoupon('123456789');
    }

    public function testQueryCoupon() {
        $transport = $this->getTransportMock();
        $transport
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('http://example.com'), $this->callback($this->getDataCallback('6f1ed002ab5595859014ebf0951522d9', 'queryCoupon', '123456789', 'secret')));
        $api = new Api('http://example.com', '6f1ed002ab5595859014ebf0951522d9', $transport);
        $api->queryCoupon('123456789', 'secret');
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testConsumeCouponWithoutCode() {
        $api = new Api('http://example.com', '6f1ed002ab5595859014ebf0951522d9', $this->getTransportMock());
        $api->consumeCoupon('', '');
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testConsumeCouponWithoutSecret() {
        $api = new Api('http://example.com', '6f1ed002ab5595859014ebf0951522d9', $this->getTransportMock());
        $api->consumeCoupon('123456789', '');
    }

    public function testConsumeCoupon() {
        $transport = $this->getTransportMock();
        $transport
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('http://example.com'), $this->callback($this->getDataCallback('6f1ed002ab5595859014ebf0951522d9', 'consumeCoupon', '123456789', 'secret')));
        $api = new Api('http://example.com', '6f1ed002ab5595859014ebf0951522d9', $transport);
        $api->consumeCoupon('123456789', 'secret');
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testUnConsumeCouponWithoutCode() {
        $api = new Api('http://example.com', '6f1ed002ab5595859014ebf0951522d9', $this->getTransportMock());
        $api->unConsumeCoupon('', '');
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testUnConsumeCouponWithoutSecret() {
        $api = new Api('http://example.com', '6f1ed002ab5595859014ebf0951522d9', $this->getTransportMock());
        $api->unConsumeCoupon('123456789', '');
    }

    public function testUnConsumeCoupon() {
        $transport = $this->getTransportMock();
        $transport
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('http://example.com'), $this->callback($this->getDataCallback('6f1ed002ab5595859014ebf0951522d9', 'unconsumeCoupon', '123456789', 'secret')));
        $api = new Api('http://example.com', '6f1ed002ab5595859014ebf0951522d9', $transport);
        $api->unConsumeCoupon('123456789', 'secret');
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testReserveWithoutCode() {
        $api = new Api('http://example.com', '6f1ed002ab5595859014ebf0951522d9', $this->getTransportMock());
        $api->reserveCoupon('');
    }

    public function testReserveCoupon() {
        $transport = $this->getTransportMock();
        $transport
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('http://example.com'), $this->callback($this->getDataCallback('6f1ed002ab5595859014ebf0951522d9', 'reserveCoupon', '123456789')));
        $api = new Api('http://example.com', '6f1ed002ab5595859014ebf0951522d9', $transport);
        $api->reserveCoupon('123456789');
    }

    /**
     * @expectedException \ZlavaDna\ApiException
     */
    public function testUnReserveWithoutCode() {
        $api = new Api('http://example.com', '6f1ed002ab5595859014ebf0951522d9', $this->getTransportMock());
        $api->unReserveCoupon('');
    }

    public function testUnReserveCoupon() {
        $transport = $this->getTransportMock();
        $transport
            ->expects($this->once())
            ->method('request')
            ->with($this->equalTo('http://example.com'), $this->callback($this->getDataCallback('6f1ed002ab5595859014ebf0951522d9', 'unReserveCoupon', '123456789')));
        $api = new Api('http://example.com', '6f1ed002ab5595859014ebf0951522d9', $transport);
        $api->unReserveCoupon('123456789');
    }

}