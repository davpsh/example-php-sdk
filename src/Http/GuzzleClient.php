<?php

namespace Example\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Example\Exceptions\HttpException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;

final class GuzzleClient implements ClientInterface
{
    /**
     * Http client instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    private $client;

    /**
     * Client constructor.
     *
     * @param \GuzzleHttp\ClientInterface $client
     *   Http client instance.
     */
    public function __construct(?GuzzleClientInterface $client = null)
    {
        $this->client = $client ?? new Client();
    }

    /**
     * {@inheritdoc}
     */
    public function request(
        string $method,
        string $url,
        array $params = [],
        array $data = [],
        array $headers = []
    ): Response {
        try {
            $options = [
                'form_params' => $data,
            ];

            if ($params) {
                $options['query'] = $params;
            }

            $response = $this->client->send(new Request($method, $url, $headers), $options);
        } catch (ClientExceptionInterface $exception) {
            $response = $exception->getResponse();
        } catch (\Throwable $exception) {
            throw new HttpException('Unable to complete the HTTP request', 0, $exception);
        }

        return new Response($response->getStatusCode(), (string) $response->getBody(), $response->getHeaders());
    }
}
