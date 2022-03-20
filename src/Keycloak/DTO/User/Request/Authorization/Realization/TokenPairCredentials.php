<?php

namespace KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization;

use KeycloakBundle\Keycloak\DTO\Token\Realization\TokenPair;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Abstraction\UserCredentials;
use KeycloakBundle\Keycloak\Enum\GrantType;

class TokenPairCredentials extends UserCredentials
{
    public function __construct(private TokenPair $pair)
    {
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'access_token' => $this->pair->getAccess()->getToken(),
            'refresh_token' => $this->pair->getRefresh()->getToken(),
            'grant_type' => $this->getGrantType()->value,
        ];
    }

    public function getGrantType(): GrantType
    {
        return GrantType::REFRESH_TOKEN;
    }
}