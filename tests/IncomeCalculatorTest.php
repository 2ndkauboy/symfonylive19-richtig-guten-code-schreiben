<?php declare(strict_types=1);
namespace IrishGauge;

use PHPUnit\Framework\TestCase;

/**
 * @covers \IrishGauge\IncomeCalculator
 */
final class IncomeCalculatorTest extends TestCase
{
    public function testCalculateDividendPayoutForOnePayingCityAndOneTown(): void
    {
        $calculator = new IncomeCalculator();
        $railway    = new Railway();
        $city       = Station::city(Cube::black());
        $town       = Station::town();
        $draw       = DividendCubeDraw::fromList(Cube::black());

        $railway->connectStationToRailway($city);
        $railway->connectStationToRailway($town);

        $this->assertTrue($railway->meetsDividendPayoutRequirements($draw));
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

        $this->assertTrue($railway->meetsDividendPayoutRequirements($draw));
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

        $this->assertFalse($railway->meetsDividendPayoutRequirements($draw));
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

        $this->assertTrue($railway->meetsDividendPayoutRequirements($draw));
        $this->assertEquals(8, $calculator->calculate($railway, $draw));
    }
}
