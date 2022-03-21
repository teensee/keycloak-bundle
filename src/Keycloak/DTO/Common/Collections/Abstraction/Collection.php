<?php

namespace KeycloakBundle\Keycloak\DTO\Common\Collections\Abstraction;

use ArrayIterator;
use Closure;

abstract class Collection implements CollectionInterface
{
    public function __construct(protected array $elements = [])
    {
    }

    public abstract function first();
    public abstract function last();
    public abstract function current();
    public abstract function next();
    public abstract function remove(int|string $key);
    public abstract function jsonSerialize(): array;
    public abstract function get(int|string $key);
    protected abstract function createFrom(array $elements): Collection;

    public function contains(mixed $element): bool
    {
        return in_array($element, $this->elements, true);
    }

    public function set(int|string $key, mixed $value): void
    {
        $this->elements[$key] = $value;
    }

    public function add(mixed $element): bool
    {
        $this->elements[] = $element;

        return true;
    }

    public function clear(): void
    {
        $this->elements = [];
    }

    public function isEmpty(): bool
    {
        return $this->elements === [];
    }

    public function getKeys(): array
    {
        return array_keys($this->elements);
    }

    public function toArray(): array
    {
        return $this->elements;
    }

    public function key(): int|string|null
    {
        return key($this->elements);
    }

    public function getValues(): array
    {
        return array_values($this->elements);
    }

    public function containsKey($key): bool
    {
        return isset($this->elements[$key]) || array_key_exists($key, $this->elements);
    }

    public function indexOf($element): bool|int|string
    {
        return array_search($element, $this->elements, true);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->elements);
    }

    public function count(): int
    {
        return count($this->elements);
    }

    public function removeElement($element): bool
    {
        $key = array_search($element, $this->elements, true);

        if ($key === false) {
            return false;
        }

        unset($this->elements[$key]);

        return true;
    }

    public function exists(Closure $p): bool
    {
        foreach ($this->elements as $key => $element) {
            if ($p($key, $element)) {
                return true;
            }
        }

        return false;
    }

    public function forAll(Closure $p): bool
    {
        foreach ($this->elements as $key => $element) {
            if (!$p($key, $element)) {
                return false;
            }
        }

        return true;
    }

    public function map(Closure $func): Collection
    {
        return $this->createFrom(array_map($func, $this->elements));
    }

    public function offsetExists($offset): bool
    {
        return $this->containsKey($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!isset($offset)) {
            $this->add($value);

            return;
        }

        $this->set($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->remove($offset);
    }
}