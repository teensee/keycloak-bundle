<?php

namespace KeycloakBundle\Keycloak\Http\Repository\Realization\User\UserInfo;

use KeycloakBundle\Keycloak\Client\Abstraction\ClientInterface;
use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;
use KeycloakBundle\Keycloak\DTO\Common\Email;
use KeycloakBundle\Keycloak\DTO\Common\Uuid4;
use KeycloakBundle\Keycloak\DTO\Token\Realization\AccessToken;
use KeycloakBundle\Keycloak\DTO\User\Request\Authorization\Realization\ClientCredentials;
use KeycloakBundle\Keycloak\DTO\User\Response\UserManagement\UserInfo;
use KeycloakBundle\Keycloak\Exception\DTO\User\UserDTOException;
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

    public function getIdByEmail(Email $email): Uuid4
    {
        $userInfo = $this->getUserInfo($email);

        return $userInfo->getId();
    }

    /**
     * @param Email $email
     *
     * @return UserInfo
     * @throws UserDTOException
     */
    public function getUserInfo(Email $email): UserInfo
    {
        $adminCredentials = new ClientCredentials(
            $this->configuration->getClientId(),
            $this->configuration->getClientSecret()
        );

        $rawToken = $this->loginRepository->login($adminCredentials);
        $access   = new AccessToken($rawToken->getAccess(), $rawToken->getExpiresIn());
        $action   = new GetIdAction($email, $access, $this->configuration);

        $rawData = $this->client->execute($action);
        $decoded = json_decode($rawData, true);
        if (json_last_error() > 0) {
            dd(json_last_error_msg());
        }

        return UserInfo::fromResponse(reset($decoded));
    }
}