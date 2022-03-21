<?php

namespace KeycloakBundle\Keycloak\Http\Repository\Abstraction\Base;

use KeycloakBundle\Keycloak\Client\Abstraction\ClientInterface;
use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\ClientCredentials;

abstract class ApiRepository implements ApiRepositoryInterface
{
    public function __construct(
        protected ClientInterface $client,
        protected ConfigurationInterface $configuration
    ) {
    }

    final protected function getClientCredentials(): ClientCredentials
    {
        return new ClientCredentials($this->configuration->getClientId(), $this->configuration->getClientSecret());
    }
}