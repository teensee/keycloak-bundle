<?php

namespace KeycloakBundle\Keycloak\DTO\User\Response\Authorization;

use KeycloakBundle\Keycloak\DTO\Token\Realization\AccessToken;
use KeycloakBundle\Keycloak\DTO\Token\Realization\RefreshToken;
use KeycloakBundle\Keycloak\DTO\Token\Realization\TokenPair;
use KeycloakBundle\Keycloak\Exception\DTO\User\DTOException;

final class SuccessAuthorization
{
    public function __construct(
        private TokenPair $pair,
        private string $tokenType,
        private string $notBeforePolicy,
        private ?string $sessionState,
        private string $scope
    ) {

    }

    /**
     * @throws DTOException
     */
    public static function fromArray(array $raw): SuccessAuthorization
    {
        if (!isset($raw['access_token']) || !isset($raw['expires_in']) || !isset($raw['scope'])) {
            throw DTOException::incorrectJsonPassed(
                SuccessAuthorization::class,
                __METHOD__,
                ['access_token', 'expires_in', 'scope']
            );
        }

        $accessToken = new AccessToken($raw['access_token'], $raw['expires_in']);
        $refreshToken = isset($raw['refresh_token'])
            ? new RefreshToken($raw['refresh_token'], $raw['refresh_expires_in'])
            : null;


        return new SuccessAuthorization(
            new TokenPair($accessToken, $refreshToken),
            $raw['token_type'],
            $raw['not-before-policy'],
            $raw['session_state'] ?? null,
            $raw['scope']
        );
    }

    /**
     * @return TokenPair
     */
    public function getPair(): TokenPair
    {
        return $this->pair;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * @return string
     */
    public function getNotBeforePolicy(): string
    {
        return $this->notBeforePolicy;
    }

    /**
     * @return string
     */
    public function getSessionState(): string
    {
        return $this->sessionState;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }
}