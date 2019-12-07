<?php

/**
 * Plugin.php - Javascript charts for Jaxon with the Flot library.
 *
 * @package jaxon-flot
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2017 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link https://github.com/jaxon-php/jaxon-flot
 */

namespace Jaxon\Flot;

class Plugin extends \Jaxon\Plugin\Response
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'flot';
    }

    /**
     * @inheritDoc
     */
    public function getHash()
    {
        // The version number is used as hash
        return '3.1.0';
    }

    /**
     * @inheritDoc
     */
    public function getJs()
    {
        if(!$this->includeAssets())
        {
            return '';
        }
        return jaxon()->template()->render('jaxon::flot::js.html');
    }

    /**
     * @inheritDoc
     */
    public function getReadyScript()
    {
        return jaxon()->template()->render('jaxon::flot::ready.js');
    }

    /**
     * Create a Plot instance.
     *
     * @param string        $sSelector            The jQuery selector
     *
     * @return Plot\Plot
     */
    public function plot($sSelector)
    {
        return new Plot\Plot($sSelector);
    }

    /**
     * Draw a Plot in a given HTML element.
     *
     * @return void
     */
    public function draw(Plot\Plot $xPlot)
    {
        $this->addCommand(array('cmd' => 'flot.plot'), $xPlot);
    }
}
