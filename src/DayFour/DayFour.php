<?php

declare(strict_types=1);

namespace Ccavanna\Aoc2025\DayFour;

class DayFour
{
    private const string ROLL_PAPER_VALUE = '@';
    private const string NO_ROLL_PAPER_VALUE = '.';

    public array $grid;

    public function __construct(
        private array $data = [],
    ) {
        $this->buildGrid();
    }

    public function buildGrid(): void
    {
        foreach ($this->data as $positionX => $dataRow) {
            $chars = str_split($dataRow);

            foreach ($chars as $positionY => $char) {
                $this->grid[$positionX][$positionY] = $char;
            }
        }
    }

    public function getValue(int $positionX, int $positionY): string
    {
        if (!isset($this->grid[$positionX][$positionY])) {
            throw new \InvalidArgumentException('position not found in the actual grid');
        }

        return $this->grid[$positionX][$positionY];
    }

    public function removeRollOfPaper(int $positionX, int $positionY): void
    {
        if (!isset($this->grid[$positionX][$positionY])) {
            return;
        }

        $this->grid[$positionX][$positionY] = self::NO_ROLL_PAPER_VALUE;
    }

    public static function isRoll(string $value): bool
    {
        if ($value === self::ROLL_PAPER_VALUE) {
            return true;
        }

        return false;
    }

    public function getNeighbors(int $x, int $y): array
    {
        $neighbors = [];
        for ($i = $x - 1; $i <= $x + 1; $i++) {
            for ($j = $y - 1; $j <= $y + 1; $j++) {
                if ($i < 0 || $j < 0) {
                    continue;
                }

                if ($i === $x && $j === $y) {
                    continue;
                }

                $neighbors[] = $this->grid[$i][$j];
            }
        }

        return $neighbors;
    }

    public function isAccessible(int $positionX, int $positionY): bool
    {
        if ($this->getValue($positionX, $positionY) !== self::ROLL_PAPER_VALUE) {
            return false;
        }

        $neighbors = $this->getNeighbors($positionX, $positionY);

        return array_count_values($neighbors)[self::ROLL_PAPER_VALUE] < 4;
    }

    public function countHowManyRollsAreAccessible(): int
    {
        $howManyRollsCanBeAccessed = 0;
        foreach ($this->grid as $x => $row) {
            foreach ($row as $y => $value) {
                if ($this->isAccessible($x, $y)) {
                    $howManyRollsCanBeAccessed++;
                }
            }
        }

        return $howManyRollsCanBeAccessed;
    }

    public function countHowManyRollsCanBeRemoved(): int
    {
        $countRollsRemoved = 0;

        $rollsThisTime = 0;
        foreach ($this->grid as $x => $row) {
            foreach ($row as $y => $value) {
                if (!$this->isAccessible($x, $y)) {
                    continue;
                }

                $this->removeRollOfPaper($x, $y);
                $rollsThisTime++;
            }
        }

        $countRollsRemoved += $rollsThisTime;

        if ($rollsThisTime > 0) {
            $countRollsRemoved += $this->countHowManyRollsCanBeRemoved();
        }

        return $countRollsRemoved;
    }
}
