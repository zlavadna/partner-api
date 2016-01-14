<?php

namespace ZlavaDna\Transport;

use ZlavaDna\ApiException;

/**
 * HTTP request.
 * Class Request
 * @package Zlavadna\Transport
 */
class Request implements IRequest {

    const GET = 'GET';
    const POST = 'POST';

    /**
     * Sends request to $url with $data.
     * @param string $url
     * @param array $data
     * @param string $method Determines type of post (GET, POST, etc).
     * @param array $options
     * @return IResponse
     * @throws ApiException
     */
    public function request($url, $data = array(), $method = 'GET', $options = array()) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new ApiException('URL is not set or not in proper format.');
        }

        $httpOptions = array();

        // method
        $method = strtoupper($method);
        if ($method !== 'GET' && $method !== 'POST') {
            throw new ApiException('Only GET and POST method are supported.');
        }
        $httpOptions['method'] = $method;

        // data
        if (!empty($data)) {
            $httpOptions['content'] = http_build_query($data);
        }

        // timeout
        if (!empty($options['timeout'])) {
            $httpOptions['timeout'] = $options['timeout'];
        }

        // response
        return new Response(file_get_contents($url, NULL, stream_context_create(array(
            'http' => $httpOptions,
        ), array())));
    }
}