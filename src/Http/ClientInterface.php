<?php

namespace Example\Http;

interface ClientInterface
{
    /**
     * Request data.
     *
     * @param string $method
     *   Method name.
     * @param string $url
     *   Url link.
     * @param array $params
     *   Request params.
     * @param array $data
     *   Request data.
     * @param array $header
     *   Request headers.
     *
     * @return \Example\Http\Response
     *   Http response.
     */
    public function request(
        string $method,
        string $url,
        array $params = [],
        array $data = [],
        array $header = []
    ): Response;
}
