<?php

namespace Example\Http;

/**
 * Response object.
 */
class Response
{
    /**
     * Response headers.
     *
     * @var array
     */
    protected $headers;

    /**
     * Response header.
     *
     * @var string|null
     */
    protected $content;

    /**
     * Response code.
     *
     * @var int
     */
    protected $statusCode;

    /**
     * Construct response instance.
     *
     * @param int $statusCode
     *   Response status code.
     * @param string|null $content
     *   Response content.
     * @param array $headers
     *   Response headers.
     */
    public function __construct(int $statusCode, ?string $content, array $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
        $this->headers = $headers;
    }

    /**
     * Get content.
     *
     * @return array
     *   Decoded response content
     */
    public function getContent(): ?array
    {
        return \json_decode($this->content, true);
    }

    /**
     * Get code.
     *
     * @return int
     *   Response code.
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Get headers.
     *
     * @return array
     *   Response code.
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Is response OK?
     *
     * @return bool
     *   Response code.
     */
    public function ok(): bool
    {
        return $this->getStatusCode() < 400;
    }

    /**
     * Response as string.
     *
     * @return string
     *   Response as string.
     */
    public function __toString(): string
    {
        return '[Response] HTTP ' . $this->getStatusCode() . ' ' . $this->content;
    }
}
