<?php

namespace KeycloakBundle\Keycloak\Http\Repository\Realization\User\Authorization;

use KeycloakBundle\Keycloak\DTO\Token\Realization\RefreshToken;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Abstraction\UserCredentials;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\TokenPairCredentials;
use KeycloakBundle\Keycloak\DTO\User\Response\Authorization\SuccessAuthorization;
use KeycloakBundle\Keycloak\Exception\Action\ActionException;
use KeycloakBundle\Keycloak\Exception\DTO\User\DTOException;
use KeycloakBundle\Keycloak\Exception\Repository\InvalidJsonException;
use KeycloakBundle\Keycloak\Http\Actions\Realization\User\Authorization\LoginAction;
use KeycloakBundle\Keycloak\Http\Actions\Realization\User\Authorization\LogoutAction;
use KeycloakBundle\Keycloak\Http\Actions\Realization\User\Authorization\RefreshAction;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\Base\ApiRepository;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\User\Authorization\AuthorizationRepositoryInterface;

class AuthorizationRepository extends ApiRepository implements AuthorizationRepositoryInterface
{
    /**
     * @throws ActionException | InvalidJsonException | DTOException
     */
    public function login(UserCredentials $credentials): SuccessAuthorization
    {
        $action   = new LoginAction($credentials, $this->configuration);
        $response = $this->client->execute($action);

        return SuccessAuthorization::fromArray($response->getDecodedContent());
    }

    /**
     * @throws InvalidJsonException
     */
    public function logout(TokenPairCredentials $credentials): void
    {
        $action   = new LogoutAction($credentials, $this->configuration);
        $response = $this->client->execute($action);
        $decoded  = $response->getDecodedContent();
    }

    /**
     * @throws InvalidJsonException | DTOException
     */
    public function refresh(RefreshToken $token): SuccessAuthorization
    {
        $action   = new RefreshAction($token, $this->configuration);
        $response = $this->client->execute($action);
        $decoded  = $response->getDecodedContent();

        return SuccessAuthorization::fromArray($decoded);
    }
}