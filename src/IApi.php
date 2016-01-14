<?php

namespace ZlavaDna;

interface IApi {

    /**
     * Checks state of a coupon.
     * If $secret is provided, checks if it's correct.
     * @param string $partnerCode
     * @param string $code
     * @param string|null $secret
     * @return mixed
     */
    public function queryCoupon($partnerCode, $code, $secret = NULL);

    /**
     * Marks a coupon as consumed.
     * @param string $partnerCode
     * @param string $code
     * @param string $secret
     * @return mixed
     */
    public function consumeCoupon($partnerCode, $code, $secret);

    /**
     * Marks a coupon as not consumed.
     * @param string $partnerCode
     * @param string $code
     * @param string $secret
     * @return mixed
     */
    public function unConsumeCoupon($partnerCode, $code, $secret);

    /**
     * Marks a coupon as reserved.
     * @param string $partnerCode
     * @param string $code
     * @return mixed
     */
    public function reserveCoupon($partnerCode, $code);

    /**
     * Marks a coupon as not reserved.
     * @param string $partnerCode
     * @param string $code
     * @return mixed
     */
    public function unReserveCoupon($partnerCode, $code);

    /**
     * Checks partner's username and password.
     * Use only over https.
     * @param string $username
     * @param string $password
     * @return mixed
     */
    public function verifyLoginData($username, $password);
}