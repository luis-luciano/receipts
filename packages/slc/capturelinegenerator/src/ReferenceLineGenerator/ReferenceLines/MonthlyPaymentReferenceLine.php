<?php

namespace CaptureLineGenerator\ReferenceLineGenerator\ReferenceLines;

class MonthlyPaymentReferenceLine implements ReferenceLine {
	/**
	 * Constant representing the establishment line.
	 *
	 * @var string
	 */
	const ESTABLISHMENT_LINE = '23';

	/**
	 * Constant representing the payment type.
	 *
	 * @var string
	 */
	const PAYMENT_TYPE = '01';

	/**
	 * The contract number 5
	 *
	 * @var string
	 */
	private $contract;

	/**
	 * The receipt number 7.
	 *
	 * @var string
	 */
	private $receiptNumber;

	/**
	 * Create a new Predial reference line instance.
	 *
	 * @param  string  $resource
	 * @param  string  $account
	 * @param  string  $childAccount
	 * @return void
	 */
	public function __construct($contract, $receiptNumber) {
		$this->contract = $contract;
		$this->receiptNumber = $receiptNumber;
	}

	/**
	 * Generate the reference line.
	 *
	 * @return string
	 */
	public function generate() {
		$contract = fillWithZeros($this->contract, 5);
		$receiptNumber = fillWithZeros($this->receiptNumber, 7);

		return self::ESTABLISHMENT_LINE . $contract . $receiptNumber;
	}
}
