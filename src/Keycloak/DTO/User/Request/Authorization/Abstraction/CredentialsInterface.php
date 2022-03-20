<?php

namespace KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Abstraction;

use JsonSerializable;
use KeycloakBundle\Keycloak\Enum\GrantType;

interface CredentialsInterface extends JsonSerializable
{
    public function toArray(): array;
    public function getGrantType(): GrantType;
}