<?php

namespace spec\Eddy\Robots\Factory;

use Eddy\Robots\Factory\ParamsFactory;
use Eddy\Robots\Factory\UserAgentFactory;
use Eddy\Robots\UserAgent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument\Token\AnyValueToken;

class UserAgentFactorySpec extends ObjectBehavior
{
    protected $testAgent;

    function let(ParamsFactory $paramsFactory)
    {
        $this->testAgent = '
        User-agent: AhrefsBot
Crawl-delay: 10
Disallow: /admin
Disallow: /cart
Disallow: /orders
Disallow: /checkouts/
Disallow: /checkout
Disallow: /457952/checkouts
Disallow: /457952/orders
Disallow: /carts
Disallow: /account
Disallow: /collections/*sort_by*
Disallow: /*/collections/*sort_by*
Disallow: /collections/*+*
Disallow: /collections/*%2B*
Disallow: /collections/*%2b*
Disallow: /*/collections/*+*
Disallow: /*/collections/*%2B*
Disallow: /*/collections/*%2b*
Disallow: /blogs/*+*
Disallow: /blogs/*%2B*
Disallow: /blogs/*%2b*
Disallow: /*/blogs/*+*
Disallow: /*/blogs/*%2B*
Disallow: /*/blogs/*%2b*
Disallow: /*?*oseid=*
Disallow: /*preview_theme_id*
Disallow: /*preview_script_id*
Disallow: /policies/
Disallow: /*/*?*ls=*&ls=*
Disallow: /*/*?*ls%3D*%3Fls%3D*
Disallow: /*/*?*ls%3d*%3fls%3d*
Disallow: /search
Allow: /apple-app-site-association
Allow: /.well-known/shopify/monorail
Allow: /cdn/wpm/*.js
Allow: /services/login_with_shop
Sitemap: https://www.pedalempire.com.au/sitemap.xml'; 

        $paramsFactory->make(new AnyValueToken())->willReturn([]);
        $this->beConstructedWith($paramsFactory);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType(UserAgentFactory::class);
    }

    function it_creates_a_user_agent_object_from_a_sections_of_a_robots_file()
    {
        $this->fromString($this->testAgent)->shouldBeAnInstanceOf(UserAgent::class);
    }
}
