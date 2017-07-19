<?php

/**
 * Plot.php - A plot containing one or more graphs. 
 *
 * @package jaxon-flot
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2017 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link https://github.com/jaxon-php/jaxon-flot
 */

namespace Jaxon\Flot\Plot;

use JsonSerializable;

class Plot implements JsonSerializable
{
    public $sSelector;
    public $aGraphs = [];
    public $aOptions;

    /**
     * The constructor.
     *
     * @param string        $sSelector            The jQuery selector
     * @param string        $sContext             A context associated to the selector
     */
    public function __construct($sSelector, $sContext = '')
    {
        $sSelector = trim($sSelector, " \t");
        $sContext = trim($sContext, " \t");
        if(($sContext))
        {
            $this->sSelector = "'" . $sSelector . "', $('" . $sContext . "')";
        }
        else
        {
            $this->sSelector = "'" . $sSelector . "'";
        }
    }

    public function addGraph(array $aOptions = [])
    {
        $xGraph = new Graph($aOptions);
        $this->aGraphs[] = $xGraph;
        return $xGraph;
    }

    /**
     * Generate the javascript call to draw this plot.
     *
     * @return string
     */
    public function getScript()
    {
        if(count($this->aGraphs) == 0)
        {
            return '';
        }
        return '$.plot(' . $this->sSelector . ',[{' . implode('},{', $this->aGraphs) . '}])';
    }

    /**
     * Magic function to generate the jQuery call.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getScript();
    }

    /**
     * Generate the jQuery call, when converting the response into json.
     *
     * This is a method of the JsonSerializable interface.
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->getScript();
    }
}
