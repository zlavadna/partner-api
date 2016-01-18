<?php

namespace ZlavaDna\Transport;

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
     * @param $json
     */
    public function __construct($json) {
        $json = json_decode($json, TRUE);
        if (!$json) {
            $this->result = FALSE;
            $this->errorCode = 0;
            $this->errorMessage = 'unknown error during request';
        } else {
            $this->result = $json['result'];
        }
        if (!empty($json['data'])) {
            $this->data = $json['data'];
        }
        if (!empty($json['error']['code'])) {
            $this->errorCode = $json['error']['code'];
        }
        if (!empty($json['error']['message'])) {
            $this->errorMessage = $json['error']['message'];
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