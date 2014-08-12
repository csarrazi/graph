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

use Graph\Vertex;
use Graph\Visitor\Visitor;
use Graph\Weight;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EdgeSpec extends ObjectBehavior
{
    function let(Vertex $source, Vertex $target)
    {
        $this->beConstructedWith($source, $target);
    }

    function it_is_initializable(Vertex $source, Vertex $target)
    {
        $this->beConstructedWith($source, $target);

        $this->getSource()->shouldReturn($source);
        $this->getTarget()->shouldReturn($target);

        $this->shouldHaveType('Graph\Edge');
    }

    function its_name_contains_the_source_and_target_names(Vertex $source, Vertex $target)
    {
        $source->getName()->willReturn('foo');
        $target->getName()->willReturn('bar');
        $this->beConstructedWith($source, $target);

        $this->getName()->shouldReturn('foo - bar');
    }

    function it_throws_an_exception_when_fetching_an_unknown_weight()
    {
        $this->shouldThrow('OutOfBoundsException')->duringGetWeight('foo');
    }

    function it_add_different_weights_in_a_array(Weight $weight1, Weight $weight2)
    {
        $weight1->getName()->willReturn('foo');
        $weight1->getValue()->willReturn(12);
        $weight2->getName()->willReturn('bar');
        $weight2->getValue()->willReturn(10);

        $this->addWeight($weight1);
        $this->addWeight($weight2);

        $this->getWeight('foo')->shouldBeEqualTo($weight1);
        $this->getWeight('bar')->shouldBeEqualTo($weight2);

        $this->getWeights()->shouldBeEqualTo(array('foo' => $weight1, 'bar' => $weight2));
    }

    function it_should_not_add_the_same_weight_type_twice(Weight $weight1, Weight $weight2)
    {
        $weight1->getName()->willReturn('foo');
        $weight1->getValue()->willReturn(12);
        $weight2->getName()->willReturn('foo');
        $weight2->getValue()->willReturn(10);


        $this->addWeight($weight1);
        $this->shouldThrow('OutofBoundsException')->duringAddWeight($weight2);
    }

    function it_should_be_loop_if_the_target_is_same_as_source(Vertex $source)
    {
        $this->beConstructedWith($source, $source);

        $this->shouldBeLoop();
    }

    function it_exposes_itself_to_visitor(Visitor $visitor)
    {
        $visitor->visitVertex($this->getTarget())->shouldBeCalled();

        $this->accept($visitor)->shouldReturn($this);
    }
}
