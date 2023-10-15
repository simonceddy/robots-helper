<?php
namespace Eddy\Robots;

class Robots implements \ArrayAccess, \IteratorAggregate
{
    public const TXT = 'robots.txt';

    private array $agents = [];

    public function __construct(array $userAgents = [])
    {
        foreach ($userAgents as $agent) {
            if (!($agent instanceof UserAgent)) {
                throw new \InvalidArgumentException(
                    'User agents must be an instance of ' . UserAgent::class
                );
            }
            $this->agents[$agent->getAgent()] = $agent;
        }
    }

    public function addAgent(UserAgent $agent, ?string $key = null): self
    {
        $this->agents[$key ?? $agent->getAgent()] = $agent;
        return $this;
    }

    public function hasAgent(string $agent): bool
    {
        return isset($this->agents[$agent]);
    }

    public function removeAgent(string $agent): self
    {
        unset($this->agents[$agent]);
        return $this;
    }

    public function getAgent(?string $agent = null): ?UserAgent
    {
        if (empty($this->agents)) return null;
        if (!isset($agent)) {
            return $this->agents['*']
                ?? $this->agents[array_key_first($this->agents)];
        }

        return $this->agents[$agent] ?? null;
    }

    public function getAgents(): array
    {
        return $this->agents;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'agent':
            case 'userAgent':
                return $this->getAgent();
            case 'agents':
            case 'userAgents':
                return $this->getAgents();
        }

        throw new \OutOfBoundsException('Undefined property: ' . $name);
    }

    public function toString(): string
    {
        $lines = [];
        foreach ($this->agents as $agent) {
            array_push($lines, $agent->toString(), '');
        }

        return implode("\n", $lines);
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->hasAgent($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->getAgent($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->addAgent($value, $offset);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->removeAgent($offset);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->agents);
    }
}
