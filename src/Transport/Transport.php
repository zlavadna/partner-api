<?php

namespace ZlavaDna\Transport;

use ZlavaDna\ApiException;

/**
 * HTTP request.
 * Class Transport
 * @package Zlavadna\Transport
 */
class Transport implements ITransport {

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

        // check whether request is over https and if all necessary extensions are loaded
        if (strpos($url, 'https://') === 0) {
            if (!extension_loaded('openssl')) {
                throw new ApiException('Openssl extension needs to be loaded for requests over https.');
            }
            if (!in_array('https', stream_get_wrappers())) {
                throw new ApiException('HTTPS stream wrapper missing.');
            }
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

        // response content type
        $httpOptions['header'] = 'Content-type: application/json';

        // response
        return new Response(file_get_contents($url, NULL, stream_context_create(array(
            'http' => $httpOptions,
        ), array())));
    }
}