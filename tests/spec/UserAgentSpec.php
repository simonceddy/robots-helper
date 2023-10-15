<?php

namespace spec\Eddy\Robots;

use Eddy\Robots\UserAgent;
use PhpSpec\ObjectBehavior;

class UserAgentSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('test', [
            'disallow' => ['/'],
            'allow' => ['/ok'],
            'hosts' => ['localhost', '127.0.0.1'],
            'sitemap' => 'site.map/sitemap.xml',
            'crawl-delay' => 10,
        ]);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType(UserAgent::class);
    }

    function it_has_allowed_paths()
    {
        $this->getAllowed()->shouldContain('/ok');
    }
    
    function it_can_find_an_allowed_path_by_array_key()
    {
        $this->getAllowed(0)->shouldReturn('/ok');
    }

    function it_has_disallowed_paths()
    {
        $this->getDisallowed()->shouldContain('/');
    }
    
    function it_can_find_a_disallowed_path_by_array_key()
    {
        $this->getDisallowed(0)->shouldReturn('/');
    }

    function it_has_hosts()
    {
        $this->getHosts()->shouldContain('localhost');
    }
    
    function it_can_find_a_host_by_array_key()
    {
        $this->getHosts(1)->shouldReturn('127.0.0.1');
    }

    function it_has_a_sitemap()
    {
        $this->getSitemap()->shouldReturn('site.map/sitemap.xml');
    }

    function it_has_a_crawl_delay()
    {
        $this->getCrawlDelay()->shouldReturn(10);
    }
}
