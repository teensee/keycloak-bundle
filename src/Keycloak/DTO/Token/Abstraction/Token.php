<?php

namespace KeycloakBundle\Keycloak\DTO\Token\Abstraction;

abstract class Token implements TokenInterface
{
    public function __construct(private string|null $token, private int|null $expiresIn)
    {
    }

    /**
     * @return int|null
     */
    public function getExpiresIn(): ?int
    {
        return $this->expiresIn;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }
}