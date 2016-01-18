<?php

namespace ZlavaDna;

use ZlavaDna\Transport\IResponse;
use ZlavaDna\Transport\ITransport;

/**
 * todo: validate arguments of all methods
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
     */
    public function queryCoupon($code, $secret = NULL) {

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
     */
    public function consumeCoupon($code, $secret) {

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
     */
    public function unConsumeCoupon($code, $secret) {

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
     */
    public function reserveCoupon($code) {

        return $this->request(array(
            'action' => 'reserveCoupon',
            'code' => $code,
        ));
    }

    /**
     * Marks a coupon as not reserved.
     * @param string $code
     * @return IResponse
     */
    public function unReserveCoupon($code) {

        return $this->request(array(
            'action' => 'unReserveCoupon',
            'code' => $code,
        ));
    }

    /**
     * Checks partner's username and password.
     * Use only over https.
     * @param string $username
     * @param string $password
     * @return IResponse
     */
    public function verifyLoginData($username, $password) {

        return $this->request(array(
            'action' => 'verifyLoginData',
            'partnerUsername' => $username,
            'partnerPassword' => $password,
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