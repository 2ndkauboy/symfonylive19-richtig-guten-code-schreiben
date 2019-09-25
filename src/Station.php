<?php declare(strict_types=1);
namespace IrishGauge;

final class Station
{
    /**
     * @var ?Cube
     */
    private $specialInterest;

    public static function town(): self
    {
        return new self(null);
    }

    public static function city(Cube $specialInterest): self
    {
        return new self($specialInterest);
    }

    private function __construct(?Cube $specialInterest)
    {
        $this->specialInterest = $specialInterest;
    }

    public function inTown(): bool
    {
        return $this->specialInterest === null;
    }

    public function inCity(): bool
    {
        return $this->specialInterest !== null;
    }

    public function placeSpecialInterest(Cube $cube): void
    {
        if ($this->specialInterest !== null) {
            throw new SpecialInterestCubeAlreadyPlacedException;
        }

        $this->specialInterest = $cube;
    }

    public function specialInterest(): Cube
    {
        if ($this->specialInterest === null) {
            throw new NoSpecialInterestException;
        }

        return $this->specialInterest;
    }
}
