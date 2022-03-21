<?php

namespace KeycloakBundle\Keycloak\Http\Repository\Abstraction\Base;

use KeycloakBundle\Keycloak\Client\Abstraction\ClientInterface;
use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;

abstract class ApiRepository implements ApiRepositoryInterface
{
    public function __construct(
        protected ClientInterface $client,
        protected ConfigurationInterface $configuration
    ) {
    }
}