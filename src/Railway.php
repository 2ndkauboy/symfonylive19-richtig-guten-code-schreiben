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
    public function __construct(Station ...$stations)
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
}
