<?php

declare(strict_types=1);

namespace Ccavanna\Aoc2025\DayFive;

class DayFive
{
    public array $freshIdRanges = [];
    public array $availableIngredientIds = [];

    public function __construct(array $input = [])
    {
        $this->buildData($input);
    }

    private function buildData(array $data): void
    {
        foreach ($data as $row) {
            if (preg_match('/^\d+\s*-\s*\d+$/', $row)) {
                $this->freshIdRanges[] = $row;

                continue;
            }

            $this->availableIngredientIds[] = $row;
        }
    }

    /**
     * @return array[min, max]
     */
    public static function getMinMaxForARange(string $idRange): array
    {
        return explode('-', $idRange, 2);
    }

    public static function isIngredientFresh(string $value, string $min, string $max): bool
    {
        return bccomp($value, $min) >= 0
            && bccomp($value, $max) <= 0;
    }

    public function howManyAvailableIngredientIdsAreFresh(): int
    {
        $howManyAvailableIngredientIds = 0;

        foreach ($this->availableIngredientIds as $availableIngredientId) {
            foreach ($this->freshIdRanges as $freshIdRange) {
                [$min, $max] = self::getMinMaxForARange($freshIdRange);

                if (self::isIngredientFresh($availableIngredientId, $min, $max)) {
                    $howManyAvailableIngredientIds++;

                    continue 2;
                }
            }
        }

        return $howManyAvailableIngredientIds;
    }

    public static function countFreshInRange(string $min, string $max): string
    {
        return bcadd(bcsub($max, $min), '1');
    }

    public static function iterateRange(string $min, string $max): \Generator
    {
        for ($current = $min; bccomp($current, $max) <= 0; $current = bcadd($current, '1')) {
            yield $current;
        }
    }

    public function sortIdRangesByMin(): void
    {
        usort(
            $this->freshIdRanges,
            static function (string $a, string $b): int {
                [$aMin, $aMax] = self::getMinMaxForARange($a);
                [$bMin, $bMax] = self::getMinMaxForARange($b);

                return [$aMin, $aMax] <=> [$bMin, $bMax];
            }
        );
    }

    public function mergeOverlappingRanges(): void
    {
        $this->sortIdRangesByMin();

        $merged = [];
        foreach ($this->freshIdRanges as $range) {
            [$min, $max] = self::getMinMaxForARange($range);

            if ($merged === []) {
                $merged[] = [$min, $max];
                continue;
            }

            $lastIndex = array_key_last($merged);
            [$lastMin, $lastMax] = $merged[$lastIndex];

            if ($min > $lastMax) {
                $merged[] = [$min, $max];
                continue;
            }

            // overlap
            $merged[$lastIndex][1] = max($lastMax, $max);
        }

        $this->freshIdRanges = array_values(array_map(
            static fn(array $r): string => $r[0] . '-' . $r[1],
            $merged
        ));
    }

    public function howManyAvailableIngredientIdsAreFreshOnlyWithRanges(): int
    {
        $this->mergeOverlappingRanges();

        $count = '0';

        foreach ($this->freshIdRanges as $freshIdRange) {
            [$min, $max] = self::getMinMaxForARange($freshIdRange);

            $count = bcadd(
                $count,
                bcadd(bcsub($max, $min), '1')
            );
        }

        return (int) $count;
    }
}
