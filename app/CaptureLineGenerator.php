<?php

namespace App;

use CaptureLineGenerator\Algorithms\Mod57B2013;
use CaptureLineGenerator\Generator;
use CaptureLineGenerator\ReferenceLineGenerator\Generator as ReferenceLineGenerator;
use CaptureLineGenerator\ReferenceLineGenerator\ReferenceLines\MonthlyPaymentReferenceLine;

class CaptureLineGenerator {

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
	public static function generate($contract, $receiptNumber, $dateString, $amount) {
		$generator = new Generator(
			new Mod57B2013(
				ReferenceLineGenerator::generate(
					new MonthlyPaymentReferenceLine($contract, $receiptNumber)
				),
				$dateString,
				$amount
			)
		);

		return $generator->generate();
	}
}
