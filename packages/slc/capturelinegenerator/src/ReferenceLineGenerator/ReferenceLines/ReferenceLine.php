<?php

namespace CaptureLineGenerator\ReferenceLineGenerator\ReferenceLines;

interface ReferenceLine
{
    /**
     * Generate the reference line.
     *
     * @return string
     */
    public function generate();
}
