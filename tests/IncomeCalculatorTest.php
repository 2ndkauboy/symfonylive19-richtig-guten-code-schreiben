<?php declare(strict_types=1);
namespace IrishGauge;

use PHPUnit\Framework\TestCase;

/**
 * @covers \IrishGauge\IncomeCalculator
 *
 * @uses \IrishGauge\Station
 * @uses \IrishGauge\Cube
 * @uses \IrishGauge\Railway
 * @uses \IrishGauge\DividendCubeDraw
 */
final class IncomeCalculatorTest extends TestCase
{
    public function testRailwayMeetsDividendPayoutRequirementWithOneCityAndOneTown(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $city       = Station::city(Cube::black());
        $town       = Station::town();
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway($city);
        $railway->connectStationToRailway($town);

        $this->assertContains($city, $railway->asArray());
        $this->assertContains($town, $railway->asArray());
        $this->assertTrue($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
    }

    public function testRailwayMeetsDividendPayoutRequirementWithTwoCites(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $black_city = Station::city(Cube::black());
        $white_city = Station::city(Cube::white());
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway($black_city);
        $railway->connectStationToRailway($white_city);

        $this->assertContains($black_city, $railway->asArray());
        $this->assertContains($white_city, $railway->asArray());
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
        $city       = Station::city(Cube::black());
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway($city);

        $this->assertContains($city, $railway->asArray());
        $this->assertFalse($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
    }

    public function testRailwayDoesNotMeetDividendPayoutRequirementWithOneTown(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $town       = Station::town();
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway($town);

        $this->assertContains($town, $railway->asArray());
        $this->assertFalse($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
    }

    public function testRailwayDoesNotMeetDividendPayoutRequirementWithTwoTowns(): void
    {
        $calculator  = new IncomeCalculator();
        $railway     = new Railway();
        $first_town  = Station::town();
        $second_town = Station::town();
        $draw        = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway($first_town);
        $railway->connectStationToRailway($second_town);

        $this->assertContains($first_town, $railway->asArray());
        $this->assertContains($second_town, $railway->asArray());
        $this->assertFalse($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
    }

    public function testCalculateDividendPayoutForOnePayingCityAndOneTown(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $city       = Station::city(Cube::black());
        $town       = Station::town();
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway($city);
        $railway->connectStationToRailway($town);

        $this->assertTrue($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
        $this->assertEquals(6, $calculator->calculate($railway, $draw));
    }

    public function testCalculateDividendPayoutForTwoPayingCity(): void
    {
        $calculator  = new IncomeCalculator();
        $railway     = new Railway();
        $first_city  = Station::city(Cube::black());
        $second_city = Station::city(Cube::black());
        $draw        = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway($first_city);
        $railway->connectStationToRailway($second_city);

        $this->assertTrue($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
        $this->assertEquals(8, $calculator->calculate($railway, $draw));
    }

    public function testCalculateDividendPayoutForTwoCitiesButNoPayingCity(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $black_city = Station::city(Cube::black());
        $white_city = Station::city(Cube::white());
        $draw       = DividendCubeDraw::fromList(Cube::pink());

        $railway->connectStationToRailway($black_city);
        $railway->connectStationToRailway($white_city);

        $this->assertFalse($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
        $this->assertEquals(0, $calculator->calculate($railway, $draw));
    }

    public function testCalculateDividendPayoutForTwoCitiesWithDuplicateCubesDrawn(): void
    {
        $calculator  = new IncomeCalculator();
        $railway     = new Railway();
        $first_city  = Station::city(Cube::black());
        $second_city = Station::city(Cube::black());
        $draw        = DividendCubeDraw::fromList(Cube::black(), Cube::black());

        $railway->connectStationToRailway($first_city);
        $railway->connectStationToRailway($second_city);

        $this->assertTrue($calculator->railwayMeetsDividendPayoutRequirements($railway, $draw));
        $this->assertEquals(8, $calculator->calculate($railway, $draw));
    }
}
