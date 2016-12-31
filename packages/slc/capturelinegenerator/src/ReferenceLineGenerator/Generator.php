<?php

namespace CaptureLineGenerator\ReferenceLineGenerator;

use CaptureLineGenerator\ReferenceLineGenerator\ReferenceLines\ReferenceLine;

class Generator
{
    /**
     * Generate a reference line.
     *
     * @param \CaptureLineGenerator\ReferenceLineGenerator\ReferenceLines\ReferenceLine $referenceLine
     * @return string
     */
    public static function generate(ReferenceLine $referenceLine)
    {
        return $referenceLine->generate();
    }
}
