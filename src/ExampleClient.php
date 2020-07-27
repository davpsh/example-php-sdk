<?php

namespace Example;

use Example\Api\Comments;
use Example\Http\ClientInterface as HttpClient;
use Example\Http\GuzzleClient;
use Example\Http\Response;

/**
 * Client class.
 */
class ExampleClient
{
    /**
     * Http client.
     *
     * @var \Example\Http\ClientInterface
     */
    private $httpClient;

    /**
     * Comments API instance.
     *
     * @var \Example\Api\Comments
     */
    private $comments;

    /**
     * Construct Example API client instance.
     *
     * @param \Example\Http\ClientInterface|null $httpClient
     *   Http client instance.
     */
    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new GuzzleClient();
    }

    /**
     * Returns comments API.
     *
     * @return \Example\Api\Comments
     *   Comments API.
     */
    public function comments(): Comments
    {
        if ($this->comments === null) {
            $this->comments = new Comments($this);
        }

        return $this->comments;
    }

    /**
     * Makes a request to the API using the configured http client.
     *
     * @param string $method
     *   HTTP Method.
     * @param string $uri
     *   Fully qualified url.
     * @param array $params
     *   Query string parameters.
     * @param array $data
     *   POST body data.
     *
     * @return \Example\Http\Response
     *   Response from the API.
     */
    public function request(string $method, string $uri, array $params = [], array $data = []): Response
    {
        $headers['User-Agent'] = 'example-php-sdk/(PHP ' . PHP_VERSION . ')';
        $headers['Accept-Charset'] = 'utf-8';
        $headers['Accept'] = 'application/json';

        if ($method === 'POST') {
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }

        return $this->getHttpClient()->request($method, $uri, $params, $data, $headers);
    }

    /**
     * Retrieve the HttpClient.
     *
     * @return \Example\Http\ClientInterface
     *   Current HttpClient.
     */
    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * Set the HttpClient.
     *
     * @param HttpClient $httpClient
     *   HttpClient to use.
     */
    public function setHttpClient(HttpClient $httpClient): void
    {
        $this->httpClient = $httpClient;
    }
}
