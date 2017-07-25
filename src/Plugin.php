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
     * Get the plugin name.
     *
     * @return string
     */
    public function getName()
    {
        return 'flot';
    }

    /**
     * Get the plugin hash.
     *
     * @return string
     */
    public function generateHash()
    {
        // The version number is used as hash
        return '1.0.0';
    }

    /**
     * Get the javascript includes.
     *
     * @return string
     */
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

    /**
     * Get the javascript code.
     *
     * @return string
     */
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
    // Set container size
    if(args.data.size.width != "")
    {
        $(args.data.selector).css({width: args.data.size.width});
    }
    if(args.data.size.height != "")
    {
        $(args.data.selector).css({height: args.data.size.height});
    }
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
    if(args.data.xaxis.points.length > 0)
    {
        var ticks = [];
        if(args.data.xaxis.labels.data != null)
        {
            for(var i = 0; i < args.data.xaxis.points.length; i++)
            {
                var point = args.data.xaxis.points[i];
                ticks.push([point, args.data.xaxis.labels.data[point]]);
            }
        }
        else if(args.data.xaxis.labels.func != null)
        {
            args.data.xaxis.labels.func = new Function("x", args.data.xaxis.labels.func);
            for(var i = 0; i < args.data.xaxis.points.length; i++)
            {
                var point = args.data.xaxis.points[i];
                ticks.push([point, args.data.xaxis.labels.func(point)]);
            }
        }
        if(ticks.length > 0)
        {
            options.xaxis = {ticks: ticks};
        }
    }
    /*if(args.data.yaxis.points.length > 0)
    {
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
     * Create a Plot instance.
     *
     * @param string        $sSelector            The jQuery selector
     *
     * @return Jaxon\Flot\Plot\Plot
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
