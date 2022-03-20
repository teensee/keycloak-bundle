<?php

namespace KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization;

use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Abstraction\UserCredentials;
use KeycloakBundle\Keycloak\Enum\GrantType;

class ClientCredentials extends UserCredentials
{
    public function __construct(private string $clientId, private string $clientSecret)
    {
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'grant_type' => $this->getGrantType()->value,
        ];
    }

    public function getGrantType(): GrantType
    {
        return GrantType::CLIENT_CREDENTIALS;
    }
}