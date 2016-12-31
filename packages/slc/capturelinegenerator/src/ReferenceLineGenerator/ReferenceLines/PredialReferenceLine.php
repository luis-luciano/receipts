<?php

namespace CaptureLineGenerator\ReferenceLineGenerator\ReferenceLines;

class PredialReferenceLine implements ReferenceLine
{
    /**
     * Constant representing the establishment line.
     *
     * @var string
     */
    const ESTABLISHMENT_LINE = '3617';

    /**
     * Constant representing the payment type.
     *
     * @var string
     */
    const PAYMENT_TYPE = '01';

    /**
     * The payment resource (arbitrio).
     *
     * @var string
     */
    private $resource;

    /**
     * The payment account (cuenta unica).
     *
     * @var string
     */
    private $account;

    /**
     * The child account (cuenta hija).
     *
     * @var string
     */
    private $childAccount;

    /**
     * Create a new Predial reference line instance.
     *
     * @param  string  $resource
     * @param  string  $account
     * @param  string  $childAccount
     * @return void
     */
    public function __construct($resource, $account, $childAccount)
    {
        $this->resource = $resource;
        $this->account = $account;
        $this->childAccount = $childAccount;
    }

    /**
     * Generate the reference line.
     *
     * @return string
     */
    public function generate()
    {
        $resource = fillWithZeros($this->resource, 8);
        $account = fillWithZeros($this->account, 8);
        $childAccount = fillWithZeros($this->childAccount, 8);

        return self::ESTABLISHMENT_LINE . self::PAYMENT_TYPE . $resource . $account . $childAccount;
    }
}
