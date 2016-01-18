<?php

namespace ZlavaDna\Transport;

interface IResponse {

    /**
     * Returns data as a result of API call.
     * @return array|null
     */
    public function getData();

    /**
     * Finds out if API call successful.
     * @return bool
     */
    public function getResult();

    /**
     * If there is any error, it will return error code.
     * Otherwise returns null.
     * @return int|null
     */
    public function getErrorCode();

    /**
     * If there is any error, it will return error message.
     * Otherwise returns null.
     * @return string|null
     */
    public function getErrorMessage();

}