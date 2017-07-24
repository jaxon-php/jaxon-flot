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
    protected $sSelector;
    protected $aGraphs = [];
    protected $aOptions;
    protected $sWidth;
    protected $sHeight;
    protected $xAxisX;
    protected $xAxisY;

    /**
     * The constructor.
     *
     * @param string        $sSelector            The jQuery selector
     */
    public function __construct($sSelector)
    {
        $this->sSelector = trim($sSelector, " \t");
        $this->xAxisX = new Ticks();
        $this->xAxisY = new Ticks();
        $this->sWidth = '';
        $this->sHeight = '';
    }

    public function width($sWidth)
    {
        $this->sWidth = trim($sWidth, " \t");
        return $this;
    }

    public function height($sHeight)
    {
        $this->sHeight = trim($sHeight, " \t");
        return $this;
    }

    public function graph(array $aOptions = [])
    {
        $xGraph = new Graph($aOptions);
        $this->aGraphs[] = $xGraph;
        return $xGraph;
    }

    public function xaxis()
    {
        return $this->xAxisX;
    }

    public function yaxis()
    {
        return $this->xAxisY;
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
            'xaxis' => $this->xAxisX,
            'yaxis' => $this->xAxisY,
            'size' => ['width' => $this->sWidth, 'height' => $this->sHeight],
        ];
    }
}
