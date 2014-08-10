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

class Weight
{
    const TYPE_INCLUSIVE = 'inclusive';
    const TYPE_EXCLUSIVE = 'exclusive';

    private $name;
    private $type;
    private $inclusive;
    private $exclusive;

    public function __construct($name, $value, $type = self::TYPE_INCLUSIVE)
    {
        $this->name = $name;
        $this->type = $type;

        $this->setValue($value, $type);
    }

    public function isInclusive()
    {
        return self::TYPE_INCLUSIVE === $this->type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getValue($type = null)
    {
        if (null === $type) {
            $type = $this->type;
        }

        if (self::TYPE_INCLUSIVE === $type) {
            return $this->inclusive;
        }

        return $this->exclusive;
    }

    public function setValue($value, $type = self::TYPE_INCLUSIVE)
    {
        if (self::TYPE_INCLUSIVE === $type) {
            $this->inclusive = $value;
        } else {
            $this->exclusive = $value;
        }
    }
}
