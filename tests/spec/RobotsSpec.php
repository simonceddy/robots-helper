<?php

namespace spec\Eddy\Robots;

use Eddy\Robots\Robots;
use PhpSpec\ObjectBehavior;

class RobotsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Robots::class);
    }
}
