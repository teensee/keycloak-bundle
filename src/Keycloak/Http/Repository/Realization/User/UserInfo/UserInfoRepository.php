<?php

namespace KeycloakBundle\Keycloak\Http\Repository\Realization\User\UserInfo;

use KeycloakBundle\Keycloak\Client\Abstraction\ClientInterface;
use KeycloakBundle\Keycloak\Configuration\Abstraction\ConfigurationInterface;
use KeycloakBundle\Keycloak\DTO\Common\Email;
use KeycloakBundle\Keycloak\DTO\Common\Uuid4;
use KeycloakBundle\Keycloak\DTO\User\Response\UserManagement\UserInfo;
use KeycloakBundle\Keycloak\Exception\DTO\User\DTOException;
use KeycloakBundle\Keycloak\Exception\Repository\InvalidJsonException;
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

    /**
     * @throws DTOException|InvalidJsonException
     */
    public function getIdByEmail(Email $email): Uuid4
    {
        $userInfo = $this->getUserInfo($email);

        return $userInfo->getId();
    }

    /**
     * @param Email $email
     *
     * @return UserInfo
     *
     * @throws DTOException|InvalidJsonException
     */
    public function getUserInfo(Email $email): UserInfo
    {
        $adminCredentials = $this->getClientCredentials();
        $token            = $this->loginRepository->login($adminCredentials);

        $action   = new GetIdAction($email, $token->getPair()->getAccess(), $this->configuration);
        $response = $this->client->execute($action);
        $decoded  = $response->getDecodedContent();

        return UserInfo::fromResponse(reset($decoded));
    }
}