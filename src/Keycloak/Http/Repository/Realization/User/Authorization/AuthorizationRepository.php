<?php

namespace KeycloakBundle\Keycloak\Http\Repository\Realization\User\Authorization;

use KeycloakBundle\Keycloak\Configuration\Realization\Configuration;
use KeycloakBundle\Keycloak\DTO\Token\Realization\RefreshToken;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Abstraction\UserCredentials;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\TokenPairCredentials;
use KeycloakBundle\Keycloak\DTO\User\Response\Authorization\SuccessAuthorization;
use KeycloakBundle\Keycloak\Http\Actions\Realization\User\Authorization\LoginAction;
use KeycloakBundle\Keycloak\Http\Actions\Realization\User\Authorization\LogoutAction;
use KeycloakBundle\Keycloak\Http\Actions\Realization\User\Authorization\RefreshAction;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\Base\ApiRepository;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\User\Authorization\AuthorizationRepositoryInterface;

class AuthorizationRepository extends ApiRepository implements AuthorizationRepositoryInterface
{
    public function login(UserCredentials $credentials): SuccessAuthorization
    {
        $action = new LoginAction($credentials, $this->configuration);
        $response = $this->client->execute($action);
        $decoded  = json_decode($response, true);

        if (json_last_error()) {
            throw new \Exception('123');
        }

        return SuccessAuthorization::fromArray($decoded);
    }

    public function logout(TokenPairCredentials $credentials): void
    {
        $action = new LogoutAction($credentials, $this->configuration);
        $response = $this->client->execute($action);
        $decoded  = json_decode($response, true);

        if (json_last_error()) {
            throw new \Exception('123');
        }
    }

    public function refresh(RefreshToken $token): SuccessAuthorization
    {
        $action = new RefreshAction($token, $this->configuration);
        $response = $this->client->execute($action);
        $decoded  = json_decode($response, true);

        if (json_last_error()) {
            throw new \Exception('123');
        }

        return SuccessAuthorization::fromArray($decoded);
    }
}