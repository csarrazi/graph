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

interface Visitable
{
    /**
     * @param Visitor $visitor
     */
    public function accept(Visitor $visitor);
}
