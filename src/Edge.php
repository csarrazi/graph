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

class Edge implements Visitable
{
    private $source;
    private $target;
    private $weights;

    /**
     * @param Vertex $source
     * @param Vertex $target
     */
    public function __construct(Vertex $source, Vertex $target)
    {
        $this->source  = $source;
        $this->target  = $target;
        $this->weights = array();
    }

    /**
     * @return Vertex
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return Vertex
     */
    public function getTarget()
    {
        return $this->target;
    }

    public function addWeight(Weight $weight)
    {
        if (isset($this->weights[$weight->getName()])) {
            throw new \OutofBoundsException(sprintf('Weight %s was already added', $weight->getName()));
            
        }

        $this->weights[$weight->getName()] = $weight;
    }

    /**
     * @return array
     */
    public function getWeights()
    {
        return $this->weights;
    }

    /**
     * @param $name
     *
     * @return Weight
     */
    public function getWeight($name)
    {
        if (isset($this->weights[$name])) {
            return $this->weights[$name];
        }

        return 0;
    }

    /**
     * @return bool
     */
    public function isLoop()
    {
        return $this->source === $this->target;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return sprintf('%s - %s', $this->source->getName(), $this->target->getName());
    }

    /**
     * {@inheritDoc}
     */
    public function accept(Visitor $visitor)
    {
        $visitor->visitEdge($this);

        return $this;
    }
}
