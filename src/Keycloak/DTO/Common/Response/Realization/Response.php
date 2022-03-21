<?php

namespace KeycloakBundle\Keycloak\DTO\Common\Response\Realization;

use KeycloakBundle\Keycloak\DTO\Common\Response\Abstraction\Response as AbstractResponse;
use KeycloakBundle\Keycloak\Exception\Repository\InvalidJsonException;

final class Response extends AbstractResponse
{
    /**
     * @throws InvalidJsonException
     */
    public function getDecodedContent(): array
    {
        $decoded = json_decode($this->getContent(), true);

        if (json_last_error()) {
            throw InvalidJsonException::fromError(json_last_error(), json_last_error_msg());
        }

        return $decoded;
    }
}