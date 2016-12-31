<?php

require __DIR__ . '/vendor/autoload.php';

use CaptureLineGenerator\Algorithms\Mod57B2013;
use CaptureLineGenerator\Generator;
use CaptureLineGenerator\ReferenceLineGenerator\Generator as ReferenceLineGenerator;
use CaptureLineGenerator\ReferenceLineGenerator\ReferenceLines\PredialReferenceLine;

$generator = new Generator(new Mod57B2013(ReferenceLineGenerator::generate(new PredialReferenceLine("176", "U0000205", "U0000205")), "20141119", "532.72"));
echo $generator->generate();

echo PHP_EOL;
die;
