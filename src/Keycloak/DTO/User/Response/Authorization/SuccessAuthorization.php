<?php

namespace KeycloakBundle\Keycloak\DTO\User\Response\Authorization;

final class SuccessAuthorization
{
    public function __construct(
        private string $access,
        private int $expiresIn,
        private ?string $refresh,
        private int $refreshExpiresIn,
        private string $tokenType,
        private string $notBeforePolicy,
        private ?string $sessionState,
        private string $scope
    ) {

    }

    public static function fromArray(array $raw): SuccessAuthorization
    {
        if (!isset($raw['access_token']) || !isset($raw['expires_in']) || !isset($raw['scope'])) {
            throw new \Exception();
        }

        return new SuccessAuthorization(
            $raw['access_token'],
            $raw['expires_in'],
            $raw['refresh_token'] ?? null,
            $raw['refresh_expires_in'],
            $raw['token_type'],
            $raw['not-before-policy'],
            $raw['session_state'] ?? null,
            $raw['scope']
        );
    }

    /**
     * @return string
     */
    public function getAccess(): string
    {
        return $this->access;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * @return string|null
     */
    public function getRefresh(): ?string
    {
        return $this->refresh;
    }

    /**
     * @return int|null
     */
    public function getRefreshExpiresIn(): ?int
    {
        return $this->refreshExpiresIn;
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