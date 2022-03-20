<?php

namespace KeycloakBundle\Tests\Services\Stubs;

use KeycloakBundle\Keycloak\Client\Abstraction\ClientInterface;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\ActionInterface;

class StubHttpClient implements ClientInterface
{
    public function execute(ActionInterface $action): string
    {
        return '{"result": "ok"}';
    }
}