<?php

/**
 * Ticks.php - Contains data to be printed in a graph. 
 *
 * @package jaxon-flot
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2017 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link https://github.com/jaxon-php/jaxon-flot
 */

namespace Jaxon\Flot\Data;

use JsonSerializable;

class Ticks implements JsonSerializable
{
    protected $aPoints;
    protected $aLabels;

    public function __construct($aPoints)
    {
        $this->aPoints = [];
        $this->aLabels = ['data' => null, 'func' => null];
    }

    public function point($iXaxis, $sLabel)
    {
        $this->aPoints[] = $iXaxis;
        if(!$this->aLabels['data'])
        {
            $this->aLabels['data'] = [];
        }
        $this->aLabels['data']["$iXaxis"] = $sLabel;
        return $this;
    }

    public function points($aPoints)
    {
        foreach($aPoints as $aPoint)
        {
            if(count($aPoint) == 2)
            {
                $this->point($aPoint[0], $aPoint[1]);
            }
        }
        return count($this->aPoints);
    }

    public function expr($iStart, $iEnd, $iStep, $sJsLabel)
    {
        for($x = $iStart; $x < $iEnd; $x += $iStep)
        {
            $this->aPoints[] = $x;
        }
        $this->aLabels['func'] = 'return ' . $sJsLabel . ';';
        return count($this->aPoints);
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
        // Surround the js var with a special marker that will later be removed
        // return '' . $this->sJsVar . '';
        $json = new \stdClass;
        $json->points = $this->aPoints;
        $json->labels = $this->aLabels;
        return $json;
    }
}
