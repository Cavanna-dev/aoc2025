<?php

require __DIR__ . '/../../Common/fetchPuzzleInput.php';

$ids = fetchAdventInput(2);

function isDoubleRepeat(int $n): bool
{
    $s = (string)$n;
    $len = strlen($s);

    if ($len % 2 !== 0) {
        return false;
    }

    $half = $len / 2;
    $p1 = substr($s, 0, $half);
    $p2 = substr($s, $half);

    return $p1 === $p2;
}

function sumInvalidIds(string $rangesIds): int
{
    $ranges = array_filter(explode(',', trim($rangesIds)));
    $sum = 0;

    foreach ($ranges as $range) {
        if (!str_contains($range, '-')) {
            continue;
        }

        [$start, $end] = array_map('intval', explode('-', $range));

        for ($i = $start; $i <= $end; $i++) {
            if (isDoubleRepeat($i)) {
                $sum += $i;
            }
        }
    }

    return $sum;
}

$result = sumInvalidIds($ids[0]);

echo "Result : $result\n";
// Result : 28846518423
