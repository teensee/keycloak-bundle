<?php

namespace KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Abstraction;

use KeycloakBundle\Keycloak\Enum\GrantType;

abstract class UserCredentials implements CredentialsInterface
{
    public abstract function jsonSerialize(): array;
    public abstract function toArray(): array;
    public abstract function getGrantType(): GrantType;
}