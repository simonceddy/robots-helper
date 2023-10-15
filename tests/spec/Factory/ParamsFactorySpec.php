<?php

namespace spec\Eddy\Robots\Factory;

use Eddy\Robots\Factory\ParamsFactory;
use PhpSpec\ObjectBehavior;

class ParamsFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ParamsFactory::class);
    }

    function it_organises_an_array_of_strings_into_valid_params_for_a_user_agent()
    {
        $d = [
            'Disallow: /',
            'Disallow: /test',
            'Disallow: /test/*',
            'Crawl-delay: 1',
        ];
        $this->make($d)->shouldHaveKeyWithValue('disallow', [
            '/', '/test', '/test/*'
        ]);
        $this->make($d)->shouldHaveKeyWithValue('crawl-delay', '1');
    }
}
