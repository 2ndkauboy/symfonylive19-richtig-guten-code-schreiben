<?php declare(strict_types=1);
namespace IrishGauge;

final class Railway
{
    /**
     * @var Station[]
     */
    private $stations;

    /**
     * Railway constructor.
     *
     * @param Station[] $stations
     */
    public function __construct(array $stations = [])
    {
        $this->stations = $stations;
    }

    public function connectStationToRailway(Station $station): void
    {
        $this->stations[] = $station;
    }

    /**
     * @return Station[]
     */
    public function asArray(): array
    {
        return $this->stations;
    }

    public function meetsDividendPayoutRequirements(): bool
    {
        return \count($this->stations) > 1 && $this->railwayHasConnectedCity();
    }

    private function railwayHasConnectedCity(): bool
    {
        foreach ($this->stations as $station) {
            if ($station->inCity()) {
                return true;
            }
        }

        return false;
    }
}
