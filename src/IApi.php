<?php

namespace ZlavaDna;

use ZlavaDna\Transport\IResponse;

interface IApi {

    /**
     * Checks state of a coupon.
     * If $secret is provided, checks if it's correct.
     * @param string $code
     * @param string|null $secret
     * @return IResponse
     */
    public function queryCoupon($code, $secret = NULL);

    /**
     * Marks a coupon as consumed.
     * @param string $code
     * @param string $secret
     * @return IResponse
     */
    public function consumeCoupon($code, $secret);

    /**
     * Marks a coupon as not consumed.
     * @param string $code
     * @param string $secret
     * @return IResponse
     */
    public function unConsumeCoupon($code, $secret);

    /**
     * Marks a coupon as reserved.
     * @param string $code
     * @return mixed
     */
    public function reserveCoupon($code);

    /**
     * Marks a coupon as not reserved.
     * @param string $code
     * @return IResponse
     */
    public function unReserveCoupon($code);

    /**
     * Checks partner's username and password.
     * Use only over https.
     * @param string $username
     * @param string $password
     * @return IResponse
     */
    public function verifyLoginData($username, $password);
}