<?php

namespace KeycloakBundle\Keycloak\Configuration\Realization;

use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function __construct(
        private string $clientId,
        private string $clientSecret,
        private string $realm
    ) {
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @return string
     */
    public function getRealm(): string
    {
        return $this->realm ?? 'master';
    }
}