<?php

namespace KeycloakBundle\Keycloak\DTO\Common\Response\Abstraction;

abstract class Response
{
    public function __construct(private string $content, private int $statusCode, private array $headers)
    {

    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}