<?php

namespace KeycloakBundle\Tests\Services\Http;

use KeycloakBundle\Keycloak\Enum\Method;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\Action;

class StubAction extends Action
{
    public function getUri(): string
    {
        return '';
    }

    public function getMethod(): Method
    {
        return Method::GET;
    }

    public function getOptions(): array
    {
        return [];
    }
}