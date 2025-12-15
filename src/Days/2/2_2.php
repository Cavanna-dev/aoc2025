<?php

require __DIR__ . '/../../Common/fetchPuzzleInput.php';

$ids = fetchAdventInput(2);

function isRepeatedNumber(string $number): bool {
    $length = strlen($number);

    for ($i = 1; $i <= intdiv($length, 2); $i++) {
        $pattern = substr($number, 0, $i);
        $repeats = intdiv($length, $i);
        if ($repeats < 2) continue;

        if (str_repeat($pattern, $repeats) === $number) {
            return true;
        }
    }

    return false;
}

function sumInvalidIds(string $input): int {
    $ranges = explode(',', $input);
    $sum = 0;

    foreach ($ranges as $range) {
        [$start, $end] = explode('-', $range);
        $start = (int)$start;
        $end = (int)$end;

        for ($n = $start; $n <= $end; $n++) {
            if (isRepeatedNumber($n)) {
                $sum += $n;
            }
        }
    }

    return $sum;
}

$result = sumInvalidIds($ids[0]);

echo "Result : $result\n";
// Result : 31578210022
