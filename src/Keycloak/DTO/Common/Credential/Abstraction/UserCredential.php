<?php

namespace KeycloakBundle\Keycloak\DTO\Common\Credential\Abstraction;

use KeycloakBundle\Keycloak\Enum\Credential;

interface UserCredential
{
    public function getType(): Credential;
    public function getValue(): string;
}