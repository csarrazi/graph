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

class Graph implements Visitable
{
    const START = '__START__';
    const END   = '__END__';

    /**
     * @var Vertex[]
     */
    private $vertices;

    /**
     * @var Edge[]
     */
    private $edges;

    /**
     * @return Vertex[]
     */
    public function getVertices()
    {
        return $this->vertices;
    }

    /**
     * @param string $name
     * @return Vertex|null
     */
    public function getVertex($name)
    {
        return isset($this->vertices[$name]) ? $this->vertices[$name] : null;
    }

    /**
     * @param string $name
     *
     * @return Vertex
     */
    public function createVertex($name)
    {
        $vertex = new Vertex($name, $this);
        $this->addVertex($vertex);

        return $vertex;
    }

    /**
     * @param Vertex $vertex
     * @throws \LogicException
     */
    public function addVertex(Vertex $vertex)
    {
        if (isset($this->vertices[$vertex->getName()])) {
            throw new \LogicException(sprintf('Vertex "%s" already exists', $vertex->getName()));
        }

        $this->vertices[$vertex->getName()] = $vertex;
    }

    /**
     * @return Edge[]
     */
    public function getEdges()
    {
        return $this->edges;
    }

    /**
     * @param Edge $edge
     */
    public function addEdge(Edge $edge)
    {
        $this->edges[] = $edge;
    }

    public function connect(Vertex $source, Vertex $target)
    {
        $this->addEdge($source->connect($target));
    }

    /**
     * {@inheritDoc}
     */
    public function accept(Visitor $visitor)
    {
        if (!$vertex = $this->getVertex(self::START)) {
            throw new \LogicException('The graph should at least have a main() node.');
        }

        $visitor->visitVertex($vertex);

        return $this;
    }
}
