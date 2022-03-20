<?php

namespace KeycloakBundle\Keycloak\Http\Actions\Abstraction;

use KeycloakBundle\Keycloak\Enum\Method;

abstract class Action implements ActionInterface
{
    public abstract function getUri(): string;
    public abstract function getMethod(): Method;
    public abstract function getOptions(): array;
}