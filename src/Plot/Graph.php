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
        return $xSeries;
    }

    public function setOptions(array $aOptions)
    {
        $this->aOptions = array_merge($this->aOptions, $aOptions);
        return $this;
    }

    /**
     * Returns a string representation of the script output (javascript) from this object
     *
     * @return string
     */
    protected function toString()
    {
        $this->aOptions['data'] = $this->xSeries;
        return json_encode($this->aOptions, JSON_FORCE_OBJECT);
    }

    /**
     * Convert this object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
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
        return $this->toString();
    }
}
