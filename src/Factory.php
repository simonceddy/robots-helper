<?php
namespace Eddy\Robots;

use Eddy\Robots\Factory\{RobotsFactory, ParamsFactory, UserAgentFactory};

final class Factory
{
    public static function make(string $robots)
    {
        return (new RobotsFactory(new UserAgentFactory(new ParamsFactory())))
            ->make($robots);
    }
}
