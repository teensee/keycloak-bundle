<?php

namespace KeycloakBundle\Keycloak\DTO\Common;

use Stringable;

class Username implements Stringable
{
    public function __construct(private string $username)
    {
    }

    public function getValue(): string
    {
        return $this->username;
    }

    public function __toString()
    {
        return $this->username;
    }
}