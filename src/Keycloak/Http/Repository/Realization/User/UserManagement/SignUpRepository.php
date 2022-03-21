<?php

namespace KeycloakBundle\Keycloak\Http\Repository\Realization\User\UserManagement;

use KeycloakBundle\Keycloak\Client\Abstraction\ClientInterface;
use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;
use KeycloakBundle\Keycloak\DTO\Common\Uuid4;
use KeycloakBundle\Keycloak\DTO\User\Request\SignUp\Realization\UserRepresentation;
use KeycloakBundle\Keycloak\Http\Actions\Realization\User\UserManagement\DeleteAction;
use KeycloakBundle\Keycloak\Http\Actions\Realization\User\UserManagement\SignUpAction;
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

    public function signup(UserRepresentation $user): bool
    {
        $adminCredentials = $this->getClientCredentials();
        $token            = $this->loginRepository->login($adminCredentials);
        $action           = new SignUpAction($user, $token->getPair()->getAccess(), $this->configuration);
        $response         = $this->client->execute($action);

        return $response->getStatusCode() === 201;
    }

    public function delete(Uuid4 $id): string
    {
        $adminCredentials = $this->getClientCredentials();
        $token            = $this->loginRepository->login($adminCredentials);
        $action           = new DeleteAction($id, $token->getPair()->getAccess(), $this->configuration);
        $response         = $this->client->execute($action);

        return true;
    }
}