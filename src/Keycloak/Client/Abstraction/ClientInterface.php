<?php

namespace KeycloakBundle\Keycloak\Client\Abstraction;

use KeycloakBundle\Keycloak\Http\Actions\Abstraction\ActionInterface;

interface ClientInterface
{
    /**
     * @param ActionInterface $action
     *
     * @return string
     */
    public function execute(ActionInterface $action): string;
}