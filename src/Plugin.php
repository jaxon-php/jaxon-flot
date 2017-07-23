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
$("#flot-tooltip").remove();
$(\'<div id="flot-tooltip"></div>\').css({
    position: "absolute",
    display: "none",
    border: "1px solid #fdd",
    padding: "2px",
    "background-color": "#fee",
    opacity: 0.80
}).appendTo("body");

jaxon.command.handler.register("flot.plot", function(args) {
    var options = args.data.options || {};
    var graphs = [];
    var showLabels = false;
    args.data.labels = {};
    for(var i = 0, ilen = args.data.graphs.length; i < ilen; i++)
    {
        var g = args.data.graphs[i];
        var graph = g.options || {};
        graph.data = [];
        if(g.values.data != null)
        {
            for(var j = 0, jlen = g.points.length; j < jlen; j++)
            {
                var x = g.points[j];
                graph.data.push([x, g.values.data[x]]);
            }
        }
        else if(g.values.func != null)
        {
            g.values.func = new Function("x", g.values.func);
            for(var j = 0, jlen = g.points.length; j < jlen; j++)
            {
                var x = g.points[j];
                graph.data.push([x, g.values.func(x)]);
            }
        }
        if(g.labels.func != null)
        {
            g.labels.func = new Function("series,x,y", g.labels.func);
        }
        if(typeof g.options.label !== "undefined" && (g.labels.data != null || g.labels.func != null))
        {
            showLabels = true;
            args.data.labels[g.options.label] = g.labels;
        }
        graphs.push(graph);
    }
    // Setting ticks
    if(args.data.xticks.points.length > 0)
    {
        var ticks = [];
        if(args.data.xticks.labels.data != null)
        {
            for(var i = 0; i < args.data.xticks.points.length; i++)
            {
                var point = args.data.xticks.points[i];
                ticks.push([point, args.data.xticks.labels.data[point]]);
            }
        }
        else if(args.data.xticks.labels.func != null)
        {
            args.data.xticks.labels.func = new Function("x", args.data.xticks.labels.func);
            for(var i = 0; i < args.data.xticks.points.length; i++)
            {
                var point = args.data.xticks.points[i];
                ticks.push([point, args.data.xticks.labels.func(point)]);
            }
        }
        if(ticks.length > 0)
        {
            alert("Setting ticks!!");
            options.xaxis = {ticks: ticks};
        }
    }
    /*if(args.data.yticks.points.length > 0)
    {
        options.yaxis.ticks = args.data.ticks.yaxis;
    }*/
    if(showLabels)
    {
        options.grid = {hoverable: true};
    }
    $.plot(args.data.selector, graphs, options);
    // Labels
    if(showLabels)
    {
        $(args.data.selector).bind("plothover", function (event, pos, item) {
            if(item)
            {
                var series = item.series.label;
                var x = item.datapoint[0]; // item.datapoint[0].toFixed(2);
                var y = item.datapoint[1]; // item.datapoint[1].toFixed(2);
                var tooltip = "";
                if(typeof args.data.labels[series] !== "undefined")
                {
                    var labels = args.data.labels[series];
                    if(labels.data != null && typeof labels.data[x] !== "undefined")
                    {
                        tooltip = labels.data[x];
                    }
                    else if(labels.func != null)
                    {
                        tooltip = labels.func(series, x, y);
                    }
                }
                if((tooltip))
                {
                    $("#flot-tooltip").html(tooltip).css({top: item.pageY+5, left: item.pageX+5}).fadeIn(200);
                }
            }
            else
            {
                $("#flot-tooltip").hide();
            }
        });
    }
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
        $this->addCommand(array('cmd' => 'flot.plot'), $xPlot);
        return $xPlot;
    }
}
