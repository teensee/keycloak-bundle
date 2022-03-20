<?php

namespace KeycloakBundle\Keycloak\Http\Actions\Realization\User\Authorization;

use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Abstraction\CredentialsInterface;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\ClientCredentials;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\PasswordCredentials;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\TokenPairCredentials;
use KeycloakBundle\Keycloak\Enum\Method;
use KeycloakBundle\Keycloak\Exception\Action\ActionException;
use KeycloakBundle\Keycloak\Http\Actions\Abstraction\Action;

final class LoginAction extends Action
{
    const ADDRESS_PATTERN = 'realms/[REALM]/protocol/openid-connect/token';

    /**
     * @throws ActionException
     */
    public function __construct(
        private CredentialsInterface $credentials,
        private ConfigurationInterface $configuration
    ) {
        if ($this->credentials instanceof TokenPairCredentials) {
            throw ActionException::incorrectCredentialObject(
                [PasswordCredentials::class, ClientCredentials::class],
                TokenPairCredentials::class
            );
        }
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
        $userCredentials = $this->credentials->toArray();

        $defaultParams = [
            'client_id' => $this->configuration->getClientId(),
            'client_secret' => $this->configuration->getClientSecret(),
        ];

        return [
            'body' => array_merge($defaultParams, $userCredentials),
            'headers' => [
                "Content-Type" => "application/x-www-form-urlencoded",
            ],
            'timeout' => 3,
        ];
    }
}