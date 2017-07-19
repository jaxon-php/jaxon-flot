<?php

/**
 * Point.php - A point to be printed on a graph. 
 *
 * @package jaxon-flot
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2017 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link https://github.com/jaxon-php/jaxon-flot
 */

namespace Jaxon\Flot\Data;

use JsonSerializable;

class Point implements JsonSerializable
{
    public $iXaxis;
    public $xValue;
    public $sLabel;

    public function __construct($iXaxis, $xValue, $sLabel = '')
    {
        $this->iXaxis = $iXaxis;
        $this->xValue = $xValue;
        $this->sLabel = $sLabel;
    }

    /**
     * Returns a string representation of the script output (javascript) from this object
     *
     * @return string
     */
    protected function toString()
    {
        return '[' . $this->iXaxis . ',' . $this->xValue .  ']';
    }

    /**
     * Convert this object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Convert this object to string, when converting the response into json.
     *
     * This is a method of the JsonSerializable interface.
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->toString();
    }
}
