<?php

namespace KeycloakBundle\Keycloak\DTO\Common\Collections\Realization;

use KeycloakBundle\Keycloak\DTO\Common\Collections\Abstraction\Collection;
use KeycloakBundle\Keycloak\DTO\Common\Credential\Abstraction\UserCredential;

class Credentials extends Collection
{
    public function first(): ?UserCredential
    {
        return reset($this->elements);
    }

    public function last(): ?UserCredential
    {
        return end($this->elements);
    }

    public function current(): ?UserCredential
    {
        return current($this->elements);
    }

    public function next(): ?UserCredential
    {
        return next($this->elements);
    }

    public function add(mixed $element): bool
    {
        if (!$element instanceof UserCredential) {
            dd(1);
        }

        return parent::add($element);
    }

    public function set(int|string $key, mixed $value): void
    {
        if (!$value instanceof UserCredential) {
            dd(1);
        }

        parent::set($key, $value);
    }

    public function remove(int|string $key): ?UserCredential
    {
        if (!isset($this->elements[$key]) && !array_key_exists($key, $this->elements)) {
            return null;
        }

        $removed = $this->elements[$key];
        unset($this->elements[$key]);

        return $removed;
    }

    public function removeElement(mixed $element): bool
    {
        if (!$element instanceof UserCredential) {
            dd(1);
        }

        return parent::removeElement($element);
    }

    public function get(int|string $key): ?UserCredential
    {
        return $this->elements[$key] ?? null;
    }

    protected function createFrom(array $elements): Credentials
    {
        return new Credentials($elements);
    }

    public function offsetGet(mixed $offset): ?UserCredential
    {
        return parent::offsetGet($offset);
    }

    public function jsonSerialize(): array
    {
        return $this->elements;
    }
}