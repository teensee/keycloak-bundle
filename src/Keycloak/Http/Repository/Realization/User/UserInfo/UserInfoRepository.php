<?php

namespace KeycloakBundle\Keycloak\Http\Repository\Realization\User\UserInfo;

use KeycloakBundle\Keycloak\Client\Abstraction\ClientInterface;
use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;
use KeycloakBundle\Keycloak\DTO\Common\Email;
use KeycloakBundle\Keycloak\DTO\Token\Realization\AccessToken;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\ClientCredentials;
use KeycloakBundle\Keycloak\Http\Actions\Realization\User\UserInfo\GetIdAction;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\Base\ApiRepository;
use KeycloakBundle\Keycloak\Http\Repository\Abstraction\User\Authorization\AuthorizationRepositoryInterface;

class UserInfoRepository extends ApiRepository
{
    public function __construct(
        private AuthorizationRepositoryInterface $loginRepository,
        protected ClientInterface $client,
        protected ConfigurationInterface $configuration
    ) {
        parent::__construct($this->client, $this->configuration);
    }

    public function getIdByEmail(Email $email)
    {
        $adminCredentials = new ClientCredentials(
            $this->configuration->getClientId(),
            $this->configuration->getClientSecret()
        );
        $rawToken         = $this->loginRepository->login($adminCredentials);
        $access           = new AccessToken($rawToken->getAccess(), $rawToken->getExpiresIn());
        $action           = new GetIdAction($email, $access, $this->configuration);

        return $this->client->execute($action);
    }
}