<?php

namespace ZlavaDna\Transport;

class Response implements IResponse {

    /**
     * Response constructor.
     * @param $json
     */
    public function __construct($json) {

    }

    /**
     * Returns data as a result of API call.
     * @return []|null
     */
    public function getData() {
        // TODO: Implement getData() method.
    }

    /**
     * Finds out if API call successful.
     * @return bool
     */
    public function getResult() {
        // TODO: Implement getResult() method.
    }

    /**
     * If there is any error, it will return error code.
     * Otherwise returns null.
     * @return int|null
     */
    public function getErrorCode() {
        // TODO: Implement getErrorCode() method.
    }

    /**
     * If there is any error, it will return error message.
     * Otherwise returns null.
     * @return string|null
     */
    public function getErrorMessage() {
        // TODO: Implement getErrorMessage() method.
    }
}