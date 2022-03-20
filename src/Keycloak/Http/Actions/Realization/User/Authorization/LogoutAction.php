<?php

namespace KeycloakBundle\Keycloak\Http\Actions\Realization\User\Authorization;

use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\TokenPairCredentials;
use KeycloakBundle\Keycloak\Enum\Method;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\Action;

final class LogoutAction extends Action
{
    const ADDRESS_PATTERN = 'realms/[REALM]/protocol/openid-connect/logout';

    public function __construct(
        private TokenPairCredentials $credentials,
        private ConfigurationInterface $configuration
    ) {
    }

    public function getUri(): string
    {
        return str_replace('[REALM]', $this->configuration->getRealm(), self::ADDRESS_PATTERN);
    }

    public function getMethod(): Method
    {
        return Method::POST;
    }

    public function getOptions(): array
    {
        $credentials = $this->credentials->toArray();
        $default     = [
            'client_id' => $this->configuration->getClientId(),
            'client_secret' => $this->configuration->getClientSecret(),
        ];

        return [
            'body' => array_merge($default, $credentials),
            'headers' => [
                "Content-Type" => "application/x-www-form-urlencoded",
            ],
        ];
    }
}