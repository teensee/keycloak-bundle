<?php

namespace KeycloakBundle\Keycloak\DTO\Common;

use JsonSerializable;
use KeycloakBundle\Keycloak\Exception\DTO\User\ModelException;
use Ramsey\Uuid\Uuid;
use Stringable;

final class Uuid4 implements JsonSerializable, Stringable
{
    private string $value;

    private function __construct(string $id)
    {
        if (!Uuid::isValid($id)) {
            throw ModelException::invalidUuid($id);
        }

        $this->value = $id;
    }

    public static function fromString(string $id): Uuid4
    {
        return new Uuid4($id);
    }

    public static function new(): Uuid4
    {
        return new Uuid4(Uuid::uuid4()->toString());
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function jsonSerialize(): array
    {
        return [
            'value' => $this->getValue(),
        ];
    }
}