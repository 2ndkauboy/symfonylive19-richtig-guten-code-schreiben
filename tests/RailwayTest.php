<?php declare(strict_types=1);
namespace IrishGauge;

use PHPUnit\Framework\TestCase;

/**
 * @covers \IrishGauge\Railway
 */
final class RailwayTest extends TestCase
{
    public function testStationCanBeConnectedToRailway(): void
    {
        $railway = new Railway();
        $town    = Station::town();

        $railway->connectStationToRailway($town);

        $this->assertContains($town, $railway->asArray());
    }
}
