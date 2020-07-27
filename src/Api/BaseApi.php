<?php

namespace Example\Api;

use apimatic\jsonmapper\JsonMapper;
use Example\Http\Response;
use Example\ExampleClient;
use Example\Models\ModelInterface;

/**
 * Abstract base API class.
 */
abstract class BaseApi
{
    /**
     * API client.
     *
     * @var \Example\ExampleClient
     */
    protected $client;

    /**
     * API base URL.
     *
     * @var string
     */
    protected $baseUrl = 'http://example.com';

    /**
     * Construct API object.
     *
     * @param \Example\ExampleClient $client
     *   API client.
     */
    public function __construct(ExampleClient $client)
    {
        $this->client = $client;
    }

    /**
     * Build absolute URL to endpoint.
     *
     * @param string $uri
     *   Endpoint URI.
     *
     * @return string
     *    Absolute URL.
     */
    public function absoluteUrl(string $uri): string
    {
        return \implode('/', [\trim($this->baseUrl, '/'), \trim($uri, '/')]);
    }

    /**
     * Make an HTTP request to the API endpoint.
     *
     * @param string $method
     *   HTTP Method to make the request.
     * @param string $uri
     *   Relative uri to make a request.
     * @param array $params
     *   Query string arguments.
     * @param array $data
     *   Post form data.
     *
     * @return \Example\Http\Response
     *   The response for the request.
     */
    public function request(string $method, string $uri, array $params = [], array $data = []): Response
    {
        $url = $this->absoluteUrl($uri);

        return $this->client->request($method, $url, $params, $data);
    }

    /**
     * Get a json mapper.
     *
     * @return \apimatic\jsonmapper\JsonMapper
     *   JsonMapper instance.
     */
    protected function getJsonMapper(): JsonMapper
    {
        return new JsonMapper();
    }

    /**
     * Map response to model.
     *
     * @param \Example\Http\Response $response
     *   Response instance.
     * @param string $model
     *   Model type.
     *
     * @return \Example\Models\ModelInterface
     *   Model instance.
     */
    protected function mapResponseToModel(Response $response, string $model): ModelInterface
    {
        $content = (object) $response->getContent();

        return $this->convertObjectToModel($content, $model);
    }

    /**
     * Map response with multiple models.
     *
     * @param \Example\Http\Response $response
     *   Response instance.
     * @param string $model
     *   Model type.
     *
     * @return \Example\Models\ModelInterface[]
     *   Model instances.
     */
    protected function mapResponseToMultipleModels(Response $response, string $model): array
    {
        $data = [];

        $content = $response->getContent();
        $rows = $content['items'] ?? [];
        // just used to avoid extra layer for data mapping.
        foreach ($rows as $row) {
            $data[] = $this->convertObjectToModel((object) $row, $model);
        }

        return $data;
    }

    /**
     * Map response with multiple models.
     *
     * @param object $object
     *   Object to convert.
     * @param string $model
     *   Model type.
     *
     * @return \Example\Models\ModelInterface
     *   Model instance.
     */
    public function convertObjectToModel($object, string $model): ModelInterface
    {
        return $this->getJsonMapper()->mapClass($object, $model);
    }
}
