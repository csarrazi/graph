<?php

/*
 * This file is part of the Graph package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace spec\Graph;

use Graph\Weight;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WeightSpec extends ObjectBehavior
{
    function it_handles_inclusive_weights()
    {
        $this->beConstructedWith('foo', 12);

        $this->shouldHaveType('Graph\Weight');
        $this->shouldBeInclusive();

        $this->getName()->shouldReturn('foo');
        $this->getType()->shouldReturn(Weight::TYPE_INCLUSIVE);
        $this->getValue()->shouldReturn(12);
    }

    function it_handles_exclusive_weights()
    {
        $this->beConstructedWith('foo', 10, Weight::TYPE_EXCLUSIVE);

        $this->shouldHaveType('Graph\Weight');
        $this->shouldNotBeInclusive();

        $this->getName()->shouldReturn('foo');
        $this->getType()->shouldReturn(Weight::TYPE_EXCLUSIVE);
        $this->getValue()->shouldReturn(10);
    }
}
