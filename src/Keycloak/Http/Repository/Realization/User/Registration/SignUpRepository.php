<?php

namespace KeycloakBundle\Keycloak\Http\Repository\Realization\User\Registration;

use KeycloakBundle\Keycloak\Client\Abstraction\ClientInterface;
use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;
use KeycloakBundle\Keycloak\DTO\Token\Realization\AccessToken;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\ClientCredentials;
use KeycloakBundle\Keycloak\DTO\User\Request\SignUp\Realization\UserRepresentation;
use KeycloakBundle\Keycloak\Http\Actions\Realization\User\Registration\SignUpAction;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\Base\ApiRepository;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\User\Authorization\AuthorizationRepositoryInterface;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\User\Registration\SignUpRepositoryInterface;

class SignUpRepository extends ApiRepository implements SignUpRepositoryInterface
{
    public function __construct(
        private AuthorizationRepositoryInterface $loginRepository,
        protected ClientInterface $client,
        protected ConfigurationInterface $configuration
    ) {
        parent::__construct($this->client, $this->configuration);
    }

    public function signup(UserRepresentation $user)
    {
        $adminCredentials = new ClientCredentials($this->configuration->getClientId(), $this->configuration->getClientSecret());
        $rawToken         = $this->loginRepository->login($adminCredentials);
        $access           = new AccessToken($rawToken->getAccess(), $rawToken->getExpiresIn());
        $action           = new SignUpAction($user, $access, $this->configuration);

        $response = $this->client->execute($action);
        dd($response);
        $decoded  = json_decode($response, true);

        if (json_last_error()) {
            throw new \Exception('123');
        }

        return '';
    }
}