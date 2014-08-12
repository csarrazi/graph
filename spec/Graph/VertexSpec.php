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

use Graph\Edge;
use Graph\Vertex;
use Graph\Visitor\Visitor;
use Graph\Weight;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VertexSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foo');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Graph\Vertex');
        $this->getName()->shouldReturn('foo');
    }

    function it_creates_an_edge_when_connecting_another_vertex(Vertex $vertex)
    {
        $this->connect($vertex)->shouldHaveType('Graph\Edge');
        $vertex->addEdge(Argument::type('Graph\Edge'))->shouldBeCalled();
        $this->getEdges()->shouldHaveCount(1);
    }

    function it_computes_a_weight_with_a_specific_type(Weight $weight1, Weight $weight2, Edge $edge1, Edge $edge2)
    {
        $weight1->getName()->willReturn('foo');
        $weight1->getValue(null)->willReturn(12)->shouldBeCalled();

        $weight2->getName()->willReturn('bar');
        $weight2->getValue(null)->willReturn(10)->shouldBeCalled();

        $edge1->getWeight('foo')->willReturn($weight1);
        $edge1->getWeight('bar')->willReturn(null);
        $edge1->getWeight('baz')->willReturn(null);
        $edge1->getTarget()->willReturn($this);

        $edge2->getWeight('foo')->willReturn(null);
        $edge2->getWeight('bar')->willReturn($weight2);
        $edge2->getWeight('baz')->willReturn(null);
        $edge2->getTarget()->willReturn($this);

        $this->addEdge($edge1);
        $this->addEdge($edge2);

        $this->computeWeight('foo')->shouldBeEqualTo(12);
        $this->computeWeight('bar')->shouldBeEqualTo(10);
        $this->computeWeight('baz')->shouldBeEqualTo(0);
    }

    function it_exposes_each_edge_to_visitor(Visitor $visitor, Edge $edge1, Edge $edge2)
    {
        $this->addEdge($edge1);
        $this->addEdge($edge2);
        $visitor->visitEdge($edge1)->shouldBeCalled();
        $visitor->visitEdge($edge2)->shouldBeCalled();

        $this->accept($visitor);
    }
}
