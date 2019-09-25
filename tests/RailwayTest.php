<?php declare(strict_types=1);
namespace IrishGauge;

use PHPUnit\Framework\TestCase;

/**
 * Class RailwayTest
 *
 * @covers
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

    public function testRailwayMeetsDividendPayoutRequirementWithCityAndTown(): void
    {
        $railway = new Railway();
        $city    = Station::city(Cube::black());
        $town    = Station::town();

        $railway->connectStationToRailway($city);
        $railway->connectStationToRailway($town);

        $this->assertContains($city, $railway->asArray());
        $this->assertContains($town, $railway->asArray());
        $this->assertTrue($railway->meetsDividendPayoutRequirements());
    }

    public function testRailwayMeetsDividendPayoutRequirementWithTwoCites(): void
    {
        $railway    = new Railway();
        $black_city = Station::city(Cube::black());
        $white_city = Station::city(Cube::white());

        $railway->connectStationToRailway($black_city);
        $railway->connectStationToRailway($white_city);

        $this->assertContains($black_city, $railway->asArray());
        $this->assertContains($white_city, $railway->asArray());
        $this->assertTrue($railway->meetsDividendPayoutRequirements());
    }

    public function testRailwayDoesNotMeetDividendPayoutRequirementWithNoStations(): void
    {
        $railway = new Railway();

        $this->assertFalse($railway->meetsDividendPayoutRequirements());
    }

    public function testRailwayDoesNotMeetDividendPayoutRequirementWithOneCity(): void
    {
        $railway = new Railway();
        $city    = Station::city(Cube::black());

        $railway->connectStationToRailway($city);

        $this->assertContains($city, $railway->asArray());
        $this->assertFalse($railway->meetsDividendPayoutRequirements());
    }

    public function testRailwayDoesNotMeetDividendPayoutRequirementWithOneTown(): void
    {
        $railway = new Railway();
        $town    = Station::town();

        $railway->connectStationToRailway($town);

        $this->assertContains($town, $railway->asArray());
        $this->assertFalse($railway->meetsDividendPayoutRequirements());
    }

    public function testRailwayDoesNotMeetDividendPayoutRequirementWithTwoTowns(): void
    {
        $railway     = new Railway();
        $first_town  = Station::town();
        $second_town = Station::town();

        $railway->connectStationToRailway($first_town);
        $railway->connectStationToRailway($second_town);

        $this->assertContains($first_town, $railway->asArray());
        $this->assertContains($second_town, $railway->asArray());
        $this->assertFalse($railway->meetsDividendPayoutRequirements());
    }
}