<?php declare(strict_types=1);
namespace IrishGauge;

class IncomeCalculator
{
    public function calculate(Railway $railway, DividendCubeDraw $draw): int
    {
        if (false === $railway->meetsDividendPayoutRequirements($draw)) {
            return 0;
        }

        $dividendPayout = 0;

        foreach ($railway->asArray() as $station) {
            if ($station->isPayingCity($draw)) {
                $dividendPayout += 4;
            } elseif ($station->inTown()) {
                $dividendPayout += 2;
            }
        }

        return $dividendPayout;
    }
}
