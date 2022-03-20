<?php

namespace KeycloakBundle\Keycloak\DTO\Token\Realization;

use KeycloakBundle\Keycloak\DTO\Token\Abstraction\Token;

final class AccessToken extends Token
{
    public function __construct(string $token, int $expiresIn)
    {
        parent::__construct($token, $expiresIn);
    }

    public function getExpiresIn(): int
    {
        return parent::getExpiresIn();
    }

    public function getToken(): string
    {
        return parent::getToken();
    }
}