<?php

namespace ZlavaDna\Transport;

interface ITransport {

    /**
     * Sends request to $url with $data.
     * @param string $url
     * @param array $data
     * @param string $method Determines type of post (GET, POST).
     * @param array $options
     * @return IResponse
     */
    public function request($url, $data = array(), $method = 'GET', $options = array());

}