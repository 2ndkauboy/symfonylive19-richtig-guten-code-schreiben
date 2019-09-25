<?php declare(strict_types=1);
namespace IrishGauge;

use PHPUnit\Framework\TestCase;

/**
 * @covers \IrishGauge\IncomeCalculator
 *
 * @uses   \IrishGauge\Station
 * @uses   \IrishGauge\Cube
 * @uses   \IrishGauge\Railway
 * @uses   \IrishGauge\DividendCubeDraw
 */
final class IncomeCalculatorTest extends TestCase
{
    public function testRailwayMeetsDividendPayoutRequirementWithOneCityAndOneTown(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway(Station::city(Cube::black()));
        $railway->connectStationToRailway(Station::town());

        $this->assertTrue($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
    }

    public function testRailwayMeetsDividendPayoutRequirementWithTwoCites(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway(Station::city(Cube::black()));
        $railway->connectStationToRailway(Station::city(Cube::white()));

        $this->assertTrue($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
    }

    public function testRailwayDoesNotMeetDividendPayoutRequirementWithNoStations(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $this->assertFalse($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
    }

    public function testRailwayDoesNotMeetDividendPayoutRequirementWithOneCity(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway(Station::city(Cube::black()));

        $this->assertFalse($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
    }

    public function testRailwayDoesNotMeetDividendPayoutRequirementWithOneTown(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway(Station::town());

        $this->assertFalse($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
    }

    public function testRailwayDoesNotMeetDividendPayoutRequirementWithTwoTowns(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway(Station::town());
        $railway->connectStationToRailway(Station::town());

        $this->assertFalse($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
    }

    public function testCalculateDividendPayoutForOnePayingCityAndOneTown(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway(Station::city(Cube::black()));
        $railway->connectStationToRailway(Station::town());

        $this->assertTrue($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
        $this->assertEquals(6, $calculator->calculate($railway, $draw));
    }

    public function testCalculateDividendPayoutForTwoPayingCity(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway(Station::city(Cube::black()));
        $railway->connectStationToRailway(Station::city(Cube::black()));

        $this->assertTrue($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
        $this->assertEquals(8, $calculator->calculate($railway, $draw));
    }

    public function testCalculateDividendPayoutForTwoCitiesButNoPayingCity(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $draw       = DividendCubeDraw::fromList(Cube::pink());

        $railway->connectStationToRailway(Station::city(Cube::black()));
        $railway->connectStationToRailway(Station::city(Cube::white()));

        $this->assertFalse($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
        $this->assertEquals(0, $calculator->calculate($railway, $draw));
    }

    public function testCalculateDividendPayoutForTwoCitiesWithDuplicateCubesDrawn(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $draw       = DividendCubeDraw::fromList(Cube::black(), Cube::black());

        $railway->connectStationToRailway(Station::city(Cube::black()));
        $railway->connectStationToRailway(Station::city(Cube::black()));

        $this->assertTrue($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
        $this->assertEquals(8, $calculator->calculate($railway, $draw));
    }
}
