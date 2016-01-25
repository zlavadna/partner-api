<?php

namespace ZlavaDna;

use ZlavaDna\Transport\IResponse;
use ZlavaDna\Transport\ITransport;

/**
 * Class Api
 * @package ZlavaDna
 */
class Api implements IApi {

    const ZLAVADNA_URL = 'https://www.zlavadna.sk/api/index.php';
    const BOOMER_URL = 'https://www.boomer.sk/api/index.php';
    const SLEVADNE_URL = 'https://www.slevadne.cz/api/index.php';

    /** @var string */
    private $projectUrl = NULL;

    /** @var string */
    private $partnerCode = NULL;

    /** @var ITransport  */
    private $transport = NULL;


    public function __construct($projectUrl, $partnerCode, ITransport $transport) {
        if (!filter_var($projectUrl, FILTER_VALIDATE_URL)) {
            throw new ApiException('URL is not set or not in proper format.');
        }
        if (!preg_match('/^[a-f0-9]{32}$/', $partnerCode)) {
            throw new ApiException('Partner code is not set or not in proper format.');
        }
        $this->projectUrl = $projectUrl;
        $this->partnerCode = $partnerCode;
        $this->transport = $transport;
    }

    /**
     * Checks state of a coupon.
     * If $secret is provided, checks if it's correct.
     * @param string $code
     * @param string|null $secret
     * @return IResponse
     * @throws ApiException
     */
    public function queryCoupon($code, $secret = NULL) {
        if (empty($code)) {
            throw new ApiException('Coupon code is mandatory!');
        }

        return $this->request(array(
            'action' => 'queryCoupon',
            'code' => $code,
            'password' => $secret,
        ));
    }

    /**
     * Marks a coupon as consumed.
     * @param string $code
     * @param string $secret
     * @return IResponse
     * @throws ApiException
     */
    public function consumeCoupon($code, $secret) {
        if (empty($code)) {
            throw new ApiException('Coupon code is mandatory!');
        }
        if (empty($secret)) {
            throw new ApiException('Coupon password is mandatory!');
        }

        return $this->request(array(
            'action' => 'consumeCoupon',
            'code' => $code,
            'password' => $secret,
        ));
    }

    /**
     * Marks a coupon as not consumed.
     * @param string $code
     * @param string $secret
     * @return IResponse
     * @throws ApiException
     */
    public function unConsumeCoupon($code, $secret) {
        if (empty($code)) {
            throw new ApiException('Coupon code is mandatory!');
        }
        if (empty($secret)) {
            throw new ApiException('Coupon password is mandatory!');
        }

        return $this->request(array(
            'action' => 'unconsumeCoupon',
            'code' => $code,
            'password' => $secret,
        ));
    }

    /**
     * Marks a coupon as reserved.
     * @param string $code
     * @return IResponse
     * @throws ApiException
     */
    public function reserveCoupon($code) {
        if (empty($code)) {
            throw new ApiException('Coupon code is mandatory!');
        }

        return $this->request(array(
            'action' => 'reserveCoupon',
            'code' => $code,
        ));
    }

    /**
     * Marks a coupon as not reserved.
     * @param string $code
     * @return IResponse
     * @throws ApiException
     */
    public function unReserveCoupon($code) {
        if (empty($code)) {
            throw new ApiException('Coupon code is mandatory!');
        }

        return $this->request(array(
            'action' => 'unReserveCoupon',
            'code' => $code,
        ));
    }

    /**
     * Makes request to API.
     * @param $data
     * @return IResponse
     */
    private function request($data) {

        return $this->transport->request($this->projectUrl, array_merge(array(
            'partnerCode' => $this->partnerCode,
        ), $data));
    }
}