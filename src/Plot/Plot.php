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
use Jaxon\Flot\Data\Ticks;

class Plot implements JsonSerializable
{
    public $sSelector;
    public $aGraphs = [];
    public $aOptions;
    protected $xTicksX;
    protected $xTicksY;

    /**
     * The constructor.
     *
     * @param string        $sSelector            The jQuery selector
     * @param string        $sContext             A context associated to the selector
     */
    public function __construct($sSelector, $sContext = '')
    {
        $this->sSelector = trim($sSelector, " \t");
        $this->xTicksX = new Ticks();
        $this->xTicksY = new Ticks();
    }

    public function graph(array $aOptions = [])
    {
        $xGraph = new Graph($aOptions);
        $this->aGraphs[] = $xGraph;
        return $xGraph;
    }

    public function xticks()
    {
        return $this->xTicksX;
    }

    public function yticks()
    {
        return $this->xTicksY;
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
        return [
            'selector' => $this->sSelector,
            'graphs' => $this->aGraphs,
            'xticks' => $this->xTicksX,
            'yticks' => $this->xTicksY,
        ];
    }
}
