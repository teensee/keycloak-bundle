<?php

namespace KeycloakBundle\Keycloak\Client\Abstraction;

use KeycloakBundle\Keycloak\DTO\Common\Response\Realization\Response;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\ActionInterface;

interface ClientInterface
{
    /**
     * @param ActionInterface $action
     *
     * @return Response
     */
    public function execute(ActionInterface $action): Response;
}