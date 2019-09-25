<?php declare(strict_types=1);
namespace IrishGauge;

class IncomeCalculator
{
    const DIVIDEND_FOR_CITY = 4;

    const DIVIDEND_FOR_TOWN = 2;

    public function calculate(Railway $railway, DividendCubeDraw $draw): int
    {
        if (false === $this->railwayMeetsDividendPayoutRequirements($railway, $draw)) {
            return 0;
        }

        $dividendPayout = 0;

        foreach ($railway->asArray() as $station) {
            if ($this->stationIsPayingCity($station, $draw)) {
                $dividendPayout += self::DIVIDEND_FOR_CITY;
            } elseif ($station->inTown()) {
                $dividendPayout += self::DIVIDEND_FOR_TOWN;
            }
        }

        return $dividendPayout;
    }

    public function railwayMeetsDividendPayoutRequirements(Railway $railway, DividendCubeDraw $draw): bool
    {
        return \count($railway->asArray()) > 1 && $this->railwayHasPayingCity($railway, $draw);
    }

    public function stationIsPayingCity(Station $station, DividendCubeDraw $draw): bool
    {
        foreach ($draw->asArray() as $specialInterest) {
            if ($station->inCity() && $station->specialInterest() instanceof $specialInterest) {
                return true;
            }
        }

        return false;
    }

    private function railwayHasPayingCity(Railway $railway, DividendCubeDraw $draw): bool
    {
        foreach ($railway->asArray() as $station) {
            if ($this->stationIsPayingCity($station, $draw)) {
                return true;
            }
        }

        return false;
    }
}
