<?php

namespace CaptureLineGenerator\Algorithms;

use DateTime;

class Mod57B2013 implements Algorithm
{
    /**
     * Constant representing a verifier for the capture line.
     *
     * @var string
     */
    const CONSTANT_VERIFIER = '2';

    /**
     * The reference line.
     *
     * @var string
     */
    private $referenceLine;

    /**
     * The date string.
     *
     * @var string
     */
    private $dateString;

    /**
     * The amount.
     *
     * @var string
     */
    private $amount;

    /**
     * Create a new Mod57B2013 algorithm instance.
     *
     * @param  string  $referenceLine
     * @param  string  $dateString
     * @param  string  $amount
     * @return void
     */
    public function __construct($referenceLine, $dateString, $amount)
    {
        $this->referenceLine = $referenceLine;
        $this->dateString = $dateString;
        $this->amount = $amount;
    }

    /**
     * Apply the algorithm.
     *
     * @return string
     */
    public function apply()
    {
        $condensedDate = $this->condenseDate($this->dateString);
        $condensedAmount = $this->condenseAmount($this->amount);
        $referenceLine = $this->normalizeReferenceLine($this->referenceLine);

        $preCaptureLine = $referenceLine . $condensedDate . $condensedAmount . self::CONSTANT_VERIFIER;
        $globalValidatorDigits = $this->generateGlobalValidatorDigits($preCaptureLine);

        $captureLine = $preCaptureLine . $globalValidatorDigits;

        return $captureLine;
    }

    /**
     * Condense the date.
     *
     * @param  string  $dateString
     * @return string
     */
    private function condenseDate($dateString)
    {
        // It's convenient to convert the date string into a DateTime object.
        $date = DateTime::createFromFormat("Ymd", $dateString);

        // We have to extract the date in fragments.
        $year = $date->format("Y");
        $month = $date->format("m");
        $day = $date->format("d");

        // We apply the algorithm to condense the date.
        $condensedYear = ($year - 2013) * 372;
        $condensedMonth = ($month - 1) * 31;
        $condensedDay = $day - 1;
        $condensedDate = $condensedYear + $condensedMonth + $condensedDay;

        return fillWithZeros($condensedDate, 4);
    }

    /**
     * Condense the amount.
     *
     * @param  string  $amount
     * @return string
     */
    private function condenseAmount($amount)
    {
        // We have to format the ammount to have exclusively two decimal digits.
        $amount = number_format($amount, 2, '.', '');

        // We don't need decimals so we offset them.
        $amount *= 100;

        $sum = $this->sumFactorWeightSequenceOn([7, 3, 1], $amount);

        $condensedAmount = $sum % 10;

        return $condensedAmount;
    }

    /**
     * Sum the factor weight sequence on a number.
     *
     * @param  array  $factorWeightSequence
     * @param  int  $number
     * @return int
     */
    private function sumFactorWeightSequenceOn($factorWeightSequence, $number)
    {
        // We need a reversed array of digits.
        $digits = reversedArrayOf($number);

        $sum = 0;
        $factorWeightSequenceSize = count($factorWeightSequence);
        for ($i = 0; $i < count($digits); $i++) {
            $sum += $digits[$i] * $factorWeightSequence[$i % $factorWeightSequenceSize];
        }

        return $sum;
    }

    /**
     * Normalize the reference line based on an equivalence table.
     *
     * @param  string  $referenceLine
     * @return string
     */
    private function normalizeReferenceLine($referenceLine)
    {
        // If the reference line is alphanumeric we need to convert the characters to their numeric representation.
        if (!ctype_digit($referenceLine)) {
            // standarize the reference line.
            $referenceLine = strtoupper($referenceLine);

            // We need to generate the equivalence table especified by this algorithm.
            // Key    Value    Key    Value    Key    Value
            // A      2        B      2        C      2
            // D      3        E      3        F      3
            // G      4        H      4        I      4
            // J      5        K      5        L      5
            // M      6        N      6        O      6
            // P      7        Q      7        R      7
            // S      8        T      8        U      8
            // V      9        W      9        X      9
            // Y      0        Z      0

            $equivalenceTable = [];
            $ascii = 65;
            for ($i = 2; $ascii < 91; $i++) {
                for ($j = 0; $j < 3 && $ascii < 91; $j++, $ascii++) {
                    $equivalenceTable[chr($ascii)] = $i % 10;
                }
            }

            // Also, we need to complete our equivalence table with the numerical portion.
            // Key    Value
            // 0      0
            // 1      1
            // 2      2
            // 3      3
            // 4      4
            // 5      5
            // 6      6
            // 7      7
            // 8      8
            // 9      9

            for ($i = 0; $i < 10; $i++) {
                $equivalenceTable["$i"] = $i;
            }

            // It's necessary to normalize every character with their respective value.
            $tmpReferenceLine = "";
            for ($i = 0; $i < strlen($referenceLine); $i++) {
                $tmpReferenceLine .= $equivalenceTable[$referenceLine[$i]];
            }

            $referenceLine = $tmpReferenceLine;
        }

        return $referenceLine;
    }

    /**
     * Generate the global validator digits for the capture line.
     *
     * @param  string  $preCaptureLine
     * @return string
     */
    private function generateGlobalValidatorDigits($preCaptureLine)
    {
        $sum = $this->sumFactorWeightSequenceOn([11, 13, 17, 19, 23], $preCaptureLine);

        $validatorDigits = $sum % 97 + 1;

        return fillWithZeros($validatorDigits, 2);
    }
}
