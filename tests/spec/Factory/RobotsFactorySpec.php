<?php

namespace spec\Eddy\Robots\Factory;

use Eddy\Robots\Factory\RobotsFactory;
use Eddy\Robots\Factory\UserAgentFactory;
use Eddy\Robots\Robots;
use Eddy\Robots\UserAgent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument\Token\AnyValueToken;

class RobotsFactorySpec extends ObjectBehavior
{
    protected string $robotsTxt;

    function let(UserAgentFactory $userAgentFactory, UserAgent $userAgent)
    {
        $this->robotsTxt = file_get_contents(dirname(dirname(dirname(__DIR__))) . '/robots.txt');
        $userAgent->getAgent()->willReturn('*');
        $userAgentFactory->make(new AnyValueToken(), new AnyValueToken())->willReturn($userAgent);
        $this->beConstructedWith($userAgentFactory);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType(RobotsFactory::class);
    }

    function it_creates_a_robots_object_from_the_a_robots_txt_files_contents()
    {
        $this->make($this->robotsTxt)->shouldBeAnInstanceOf(Robots::class);
    }
}
