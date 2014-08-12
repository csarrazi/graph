<?php

/*
 * This file is part of the Graph package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace Graph;

use Graph\Visitor\Visitable;
use Graph\Visitor\Visitor;

class Vertex implements Visitable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Edge[]
     */
    private $edges;

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->name    = $name;
        $this->edges   = array();
    }

    /**
     * @return Edge[]
     */
    public function getEdges()
    {
        return $this->edges;
    }

    public function addEdge(Edge $edge)
    {
        $this->edges[] = $edge;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Vertex $vertex
     *
     * @return Edge
     * @throws \InvalidArgumentException
     */
    public function connect(Vertex $vertex)
    {
        $edge = new Edge($this, $vertex);
        $this->addEdge($edge);
        $vertex->addEdge($edge);

        return $edge;
    }

    public function computeWeight($name, $type = null)
    {
        $that = $this;
        $edges = array_filter($this->getEdges(), function (Edge $edge) use ($that) {
            return $edge->getTarget() === $that;
        });

        return array_reduce($edges, function ($carry, Edge $edge) use ($name, $type) {
            if ($weight = $edge->getWeight($name)) {
                return $carry + $weight->getValue($type);
            }

             return $carry;
        }, 0);
    }

    /**
     * {@inheritDoc}
     */
    public function accept(Visitor $visitor)
    {
        foreach ($this->edges as $edge) {
            $visitor->visitEdge($edge);
        }

        return $this;
    }
}
