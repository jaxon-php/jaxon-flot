<?php

namespace Jaxon\Flot;

class Plugin extends \Jaxon\Plugin\Response
{
    use \Jaxon\Utils\ContainerTrait;

    public function getName()
    {
        return 'flot';
    }

    public function generateHash()
    {
        // The version number is used as hash
        return '0.1.2';
    }

    public function getJs()
    {
        if(!$this->includeAssets())
        {
            return '';
        }
        return  '
<script type="text/javascript" src="//lib.jaxon-php.org/flot/0.8.3/jquery.flot.js"></script>
<script type="text/javascript" src="//lib.jaxon-php.org/flot/0.8.3/jquery.flot.tooltip.js"></script>
<script type="text/javascript" src="//lib.jaxon-php.org/flot/0.8.3/jquery.flot.resize.js"></script>
<script type="text/javascript" src="//lib.jaxon-php.org/flot/0.8.3/jquery.flot.tickrotor.js"></script>';
    }

    public function getScript()
    {
        return '';
    }

    public function showGraph($container, $graphData)
    {
        // Flot js code
        $js = '$.plot($("#' . $container . '"),' . $graphData['points'] .
            ',{series:{lines:{show:true},points:{show:true}},' .
            'xaxis:{ticks:' . $graphData['labels'] . ',rotateTicks:' . $graphData['xrotate'] . '},' .
            'yaxis:{min:0},grid:{hoverable:true},tooltip:true,tooltipOpts:{content:"%ct"}})';
        $this->response()->script($js);
    }
}
