<?php

namespace KeycloakBundle\Keycloak\DTO\Common\Credential\Realization;

use JsonSerializable;
use KeycloakBundle\Keycloak\DTO\Common\Credential\Abstraction\UserCredential;
use KeycloakBundle\Keycloak\Enum\Credential;

final class Password implements UserCredential, JsonSerializable
{
    public function __construct(private string $value, private bool $temporary = true)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isTemporary(): bool
    {
        return $this->temporary;
    }

    public function getType(): Credential
    {
        return Credential::PASSWORD;
    }

    public function jsonSerialize(): array
    {
        return [
            'value' => $this->getValue(),
            'type' => $this->getType()->value,
            'temporary' => $this->isTemporary(),
        ];
    }
}