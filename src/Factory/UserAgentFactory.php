<?php

namespace Eddy\Robots\Factory;

use Eddy\Robots\UserAgent;

class UserAgentFactory
{
    public function __construct(private ParamsFactory $paramsFactory)
    {}

    public function make(mixed $data, ?string $agent = null)
    {
        if (is_string($data)) return $this->fromString($data);
        else if (!is_array($data)) {
            throw new \InvalidArgumentException(
                'User Agent data must be a string or an array of strings!'
            );
        } else if (empty($data)) {
            throw new \InvalidArgumentException(
                'User Agent data is empty!'
            );
        }
        $ag = $agent
            ?? trim(preg_replace('/^User\-A?a?gent\:\s?/', '', array_shift($data)));

        $options = $this->paramsFactory->make($data);

        return new UserAgent($ag, $options);
    }

    public function fromString(string $agent)
    {
        $bits = [...array_filter(explode("\n", $agent), function($bit) {
            if (preg_match('/^\#\s?/', $bit)) return false;
            return strlen(trim($bit)) > 0;
        })];

        return $this->make($bits);
    }
}
