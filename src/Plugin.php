<?php

namespace Jaxon\Flot;

class Plugin extends \Jaxon\Plugin\Response
{
    public function getName()
    {
        return 'flot';
    }

    public function generateHash()
    {
        // The version number is used as hash
        return '1.0.0';
    }

    public function getJs()
    {
        if(!$this->includeAssets())
        {
            return '';
        }
        return '
<script type="text/javascript" src="https://cdn.jaxon-php.org/libs/flot/0.8.3/jquery.flot.js"></script>
<script type="text/javascript" src="https://cdn.jaxon-php.org/libs/flot/0.8.3/jquery.flot.tooltip.js"></script>
<script type="text/javascript" src="https://cdn.jaxon-php.org/libs/flot/0.8.3/jquery.flot.resize.js"></script>
<script type="text/javascript" src="https://cdn.jaxon-php.org/libs/flot/0.8.3/jquery.flot.tickrotor.js"></script>';
    }

    public function getScript()
    {
        return '
jaxon.command.handler.register("flot", function(args) {
    jaxon.js.execute(args);
});
';
    }

    /**
     * Create a Plot instance with a given selector, and link it to the current response.
     *
     * Since this element is linked to a response, its code will be automatically sent to the client.
     *
     * @param string        $sSelector            The jQuery selector
     * @param string        $sContext             A context associated to the selector
     *
     * @return Jaxon\Flot\Plot\Plot
     */
    public function plot($sSelector = '', $sContext = '')
    {
        $xPlot = new Plot\Plot($sSelector, $sContext);
        $this->addCommand(array('cmd' => 'flot'), $xPlot);
        return $xPlot;
    }

    /*public function showGraph($container, $graphData)
    {
        // Flot js code
        $js = '$.plot($("#' . $container . '"),' . $graphData['points'] .
            ',{series:{lines:{show:true},points:{show:true}},' .
            'xaxis:{ticks:' . $graphData['labels'] . ',rotateTicks:' . $graphData['xrotate'] . '},' .
            'yaxis:{min:0},grid:{hoverable:true},tooltip:true,tooltipOpts:{content:"%ct"}})';
        $this->response()->script($js);
    }*/
}
