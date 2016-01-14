<?php

namespace ZlavaDna;

class Api implements IApi {

    /**
     * Checks state of a coupon.
     * If $secret is provided, checks if it's correct.
     * @param string $partnerCode
     * @param string $code
     * @param string|null $secret
     * @return mixed
     */
    public function queryCoupon($partnerCode, $code, $secret = NULL) {
        // TODO: Implement queryCoupon() method.
    }

    /**
     * Marks a coupon as consumed.
     * @param string $partnerCode
     * @param string $code
     * @param string $secret
     * @return mixed
     */
    public function consumeCoupon($partnerCode, $code, $secret) {
        // TODO: Implement consumeCoupon() method.
    }

    /**
     * Marks a coupon as not consumed.
     * @param string $partnerCode
     * @param string $code
     * @param string $secret
     * @return mixed
     */
    public function unConsumeCoupon($partnerCode, $code, $secret) {
        // TODO: Implement unConsumeCoupon() method.
    }

    /**
     * Marks a coupon as reserved.
     * @param string $partnerCode
     * @param string $code
     * @return mixed
     */
    public function reserveCoupon($partnerCode, $code) {
        // TODO: Implement reserveCoupon() method.
    }

    /**
     * Marks a coupon as not reserved.
     * @param string $partnerCode
     * @param string $code
     * @return mixed
     */
    public function unReserveCoupon($partnerCode, $code) {
        // TODO: Implement unReserveCoupon() method.
    }

    /**
     * Checks partner's username and password.
     * Use only over https.
     * @param string $username
     * @param string $password
     * @return mixed
     */
    public function verifyLoginData($username, $password) {
        // TODO: Implement verifyLoginData() method.
    }
}