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

use Jaxon\Plugin\Response;
use Jaxon\Utils\Template\Engine as TemplateEngine;
use Jaxon\Flot\Plot\Plot;

use function realpath;

class Plugin extends Response
{
    /**
     * @var TemplateEngine
     */
    protected $xTemplateEngine;

    /**
     * The constructor
     *
     * @param TemplateEngine $xTemplateEngine
     */
    public function __construct(TemplateEngine $xTemplateEngine)
    {
        $this->xTemplateEngine = $xTemplateEngine;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'flot';
    }

    /**
     * @inheritDoc
     */
    public function getHash(): string
    {
        // The version number is used as hash
        return '3.1.0';
    }

    /**
     * @inheritDoc
     */
    public function getJs(): string
    {
        return $this->xTemplateEngine->render('jaxon::flot::js.html');
    }

    /**
     * @inheritDoc
     */
    public function getReadyScript(): string
    {
        return $this->xTemplateEngine->render('jaxon::flot::ready.js');
    }

    /**
     * Create a Plot instance.
     *
     * @param string        $sSelector            The jQuery selector
     *
     * @return Plot
     */
    public function plot($sSelector): Plot
    {
        return new Plot($sSelector);
    }

    /**
     * Draw a Plot in a given HTML element.
     *
     * @return void
     */
    public function draw(Plot $xPlot)
    {
        $this->addCommand(['cmd' => 'flot.plot'], $xPlot);
    }
}
