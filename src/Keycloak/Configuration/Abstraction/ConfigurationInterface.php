<?php

namespace KeycloakBundle\Keycloak\Configuration\Abstraction;

interface ConfigurationInterface
{
    public function getClientId(): string;
    public function getClientSecret(): string;
    public function getRealm(): string;
}