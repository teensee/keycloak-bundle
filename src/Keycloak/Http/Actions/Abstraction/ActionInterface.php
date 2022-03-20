<?php

namespace KeycloakBundle\Keycloak\Http\Actions\Abstraction;

use KeycloakBundle\Keycloak\Enum\Method;

interface ActionInterface
{
    /**
     * @return Method
     */
    public function getMethod(): Method;

    /**
     * @return string
     */
    public function getUri(): string;

    /**
     * @return array
     */
    public function getOptions(): array;
}