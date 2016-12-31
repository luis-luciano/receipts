<?php

namespace CaptureLineGenerator;

use CaptureLineGenerator\Algorithms\Algorithm;

class Generator
{
    /**
     * The algorithm to apply.
     *
     * @var mixed
     */
    private $algorithm;

    /**
     * Create a new Generator instance.
     *
     * @param  \CaptureLineGenerator\Algorithms\Algorithm  $algorithm
     * @return void
     */
    public function __construct(Algorithm $algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * Generate the capture line using an algorithm.
     *
     * @return string
     */
    public function generate()
    {
        return $this->algorithm->apply();
    }
}
