<?php

namespace App;

use CaptureLineGenerator\Algorithms\Mod57B2013;
use CaptureLineGenerator\Generator;
use CaptureLineGenerator\ReferenceLineGenerator\Generator as ReferenceLineGenerator;
use CaptureLineGenerator\ReferenceLineGenerator\ReferenceLines\PredialReferenceLine;

class CaptureLineGenerator
{

    /**
     * Generate the capture line.
     *
     * @param  string  $resource
     * @param  string  $account
     * @param  string  $childAccount
     * @param  string  $dateString
     * @param  string  $amount
     * @return void
     */
    public static function generate($resource, $account, $childAccount, $dateString, $amount)
    {
        $generator = new Generator(
            new Mod57B2013(
                ReferenceLineGenerator::generate(
                    new PredialReferenceLine($resource, $account, $childAccount)
                ),
                $dateString,
                $amount
            )
        );

        return $generator->generate();
    }
}
