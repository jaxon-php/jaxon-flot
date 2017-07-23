<?php

namespace Jaxon\Flot\Plot;

use JsonSerializable;
use Jaxon\Flot\Data\Series;

class Graph implements JsonSerializable
{
    public $xSeries;
    public $aOptions = [];

    /**
     * The constructor
     */
    public function __construct(array $aOptions = [])
    {
        $this->xSeries = new Series();
        $this->aOptions = $aOptions;
    }

    /**
     * Get this plot dataset
     * 
     * @return \Jaxon\Flot\Series\Series
     */
    public function series()
    {
        return $this->xSeries;
    }

    public function setOptions(array $aOptions)
    {
        $this->aOptions = array_merge($this->aOptions, $aOptions);
        return $this;
    }

    /**
     * Convert this object to string, when converting the response into json.
     *
     * This is a method of the JsonSerializable interface.
     *
     * @return string
     */
    public function jsonSerialize()
    {
        $json = $this->xSeries->jsonSerialize();
        $json->options = $this->aOptions;
        return $json;
    }
}
