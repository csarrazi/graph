<?php

/*
 * This file is part of the Graph package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace Graph\Visitor;

use Graph\Edge;
use Graph\Graph;
use Graph\Vertex;

interface Visitor
{
    /**
     * @param Graph $graph
     *
     * @return mixed
     */
    public function visit(Graph $graph);

    /**
     * @param Edge $edge
     *
     * @return mixed
     */
    public function visitEdge(Edge $edge);

    /**
     * @param Vertex $vertex
     *
     * @return mixed
     */
    public function visitVertex(Vertex $vertex);
}
