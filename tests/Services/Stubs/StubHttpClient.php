<?php

namespace KeycloakBundle\Tests\Services\Stubs;

use KeycloakBundle\Keycloak\Client\Abstraction\ClientInterface;
use KeycloakBundle\Keycloak\DTO\Common\Response\Realization\Response;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\ActionInterface;

class StubHttpClient implements ClientInterface
{
    public function execute(ActionInterface $action): Response
    {
        return new Response('{"result": "ok"}', 200, []);
    }
}