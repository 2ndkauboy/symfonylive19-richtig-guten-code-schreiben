<?php declare(strict_types=1);
namespace IrishGauge;

use PHPUnit\Framework\TestCase;

/**
 * @covers \IrishGauge\Station
 *
 * @uses \IrishGauge\Cube
 * @uses \IrishGauge\WhiteCube
 */
final class StationTest extends TestCase
{
    public function testCanBeInATown(): void
    {
        $station = Station::town();

        $this->assertTrue($station->inTown());
        $this->assertFalse($station->inCity());
    }

    public function testCanBeInACity(): void
    {
        $station = Station::city(Cube::white());

        $this->assertTrue($station->inCity());
        $this->assertFalse($station->inTown());
    }

    public function testSpecialInterestCubeCanBePlacedWhenInTown(): void
    {
        $station = Station::town();

        $station->placeSpecialInterest(Cube::white());

        $this->assertTrue($station->inCity());
        $this->assertTrue($station->specialInterest()->isWhite());
    }

    public function testHasSpecialInterestCubeWhenInCity(): void
    {
        $station = Station::city(Cube::white());

        $this->assertTrue($station->specialInterest()->isWhite());
    }

    public function testSpecialInterestCubeCannotBePlacedWhenInACity(): void
    {
        $station = Station::city(Cube::white());

        $this->expectException(SpecialInterestCubeAlreadyPlacedException::class);

        $station->placeSpecialInterest(Cube::white());
    }

    public function testSpecialInterestCubeCannotBeGetForTown(): void
    {
        $station = Station::town();

        $this->expectException(NoSpecialInterestException::class);

        $station->specialInterest();
    }
}
