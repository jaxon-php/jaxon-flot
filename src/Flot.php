<?php

namespace Xajax\Flot;

class Flot extends \Xajax\Plugin\Response
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

	public function getJsInclude()
 	{
		if(!$this->getOption('assets.include.all') && !$this->getOption('assets.include.flot'))
		{
			return '';
		}
 		return  '
<script type="text/javascript" src="//assets.lagdo-software.net/libs/flot/0.8.3/jquery.flot.js"></script>
<script type="text/javascript" src="//assets.lagdo-software.net/libs/flot/0.8.3/jquery.flot.tooltip.js"></script>
<script type="text/javascript" src="//assets.lagdo-software.net/libs/flot/0.8.3/jquery.flot.resize.js"></script>
<script type="text/javascript" src="//assets.lagdo-software.net/libs/flot/0.8.3/jquery.flot.tickrotor.js"></script>';
 	}

	/*public function getClientScript()
	{
		return '
xajax.command.handler.register("graph", function(args) {
	var options = {
		series: {
			lines: {show: true},
			points: {show: true}
		},
		xaxis: {
			ticks: args.data.labels,
			rotateTicks: args.data.xrotate
		},
		yaxis: {
			min:0
		},
		grid:{
			hoverable: true
		},
		tooltip: true,
		tooltipOpts: {
			content:"%ct"
		}
	};
	$.plot($("#" + args.data.container), args.data.points, options);
});
';
	}*/

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