<?php

namespace KeycloakBundle\Keycloak\Client\Realization;

use KeycloakBundle\Keycloak\Client\Abstraction\ClientInterface;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\ActionInterface;
use Symfony\Component\Stopwatch\Stopwatch;

final class TraceableKeycloakClient implements ClientInterface
{
    public function __construct(private ClientInterface $wrapped, private Stopwatch $stopwatch)
    {
    }

    public function execute(ActionInterface $action): string
    {
        $this->stopwatch->start('keycloak.http_client.execute_request');
        $response = $this->wrapped->execute($action);
        $this->stopwatch->stop('keycloak.http_client.execute_request');

        return $response;
    }
}