<?php

namespace ZlavaDna\Transport;

use ZlavaDna\ApiException;

class Response implements IResponse {

    /** @var bool */
    private $result = NULL;

    /** @var array|null */
    private $data = NULL;

    /** @var int|null  */
    private $errorCode = NULL;

    /** @var string|null  */
    private $errorMessage = NULL;

    /**
     * Response constructor.
     * @param string $json
     * @throws ApiException
     */
    public function setResponseData($json) {
        $json = json_decode($json, TRUE);
        if (!$json) {
            $this->result = FALSE;
            $this->data = NULL;
            $this->errorCode = 0;
            $this->errorMessage = 'unknown error during request';
        } else {
            if (!isset($json['result'])) {
                throw new ApiException('JSON data have invalid structure!');
            }
            if (filter_var($json['result'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === NULL) {
                throw new ApiException('JSON data are invalid!');
            }
            $this->result = $json['result'];

            if (!empty($json['data'])) {
                $this->data = $json['data'];
            } else {
                $this->data = NULL;
            }
            if (!empty($json['error']['code'])) {
                if (!is_numeric($json['error']['code'])) {
                    throw new ApiException('JSON data are invalid!');
                }
                $this->errorCode = (int)$json['error']['code'];
            } else {
                $this->errorCode = NULL;
            }
            if (!empty($json['error']['message'])) {
                if (!is_string($json['error']['message'])) {
                    throw new ApiException('JSON data are invalid!');
                }
                $this->errorMessage = $json['error']['message'];
            } else {
                $this->errorMessage = NULL;
            }
        }
    }

    /**
     * Returns data as a result of API call.
     * @return array|null
     */
    public function getData() {

        return $this->data;
    }

    /**
     * Finds out if API call successful.
     * @return bool
     */
    public function getResult() {

        return $this->result;
    }

    /**
     * If there is any error, it will return error code.
     * Otherwise returns null.
     * @return int|null
     */
    public function getErrorCode() {

        return $this->errorCode;
    }

    /**
     * If there is any error, it will return error message.
     * Otherwise returns null.
     * @return string|null
     */
    public function getErrorMessage() {

        return $this->errorMessage;
    }
}