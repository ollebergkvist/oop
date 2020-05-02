<?php

namespace Olbe19\Dice;

/**
 * Generating histogram data.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;

    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Return histogram as string.
     *
     * @return string with histogram.
     */
    public function getAsText()
    {
        $result = "";
        $values = $this->getSerie();
        $min = $this->min;
        $max = $this->max;

        for ($i = $min; $i <=  $max; $i++) {
            $row = "";
            foreach ($values as $value) {
                if ($value == $i) {
                    $row = $row . "*";
                }
            }

            // Returns string containing value
            $result = $result . "<br>";
            $result = $result . $i . ": ";
            $result = $result . $row;
            $result = $result . "<br>";
        }

        return $result;
    }

    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object)
    {
        $this->serie = array_merge($this->serie, $object->getHistogramSerie());
        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }
}
