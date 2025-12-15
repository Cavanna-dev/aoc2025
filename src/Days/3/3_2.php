<?php

require __DIR__ . '/../../Common/fetchPuzzleInput.php';

$batteriesBanks = fetchAdventInput(3);

$startTime = microtime(true);
$startMemory = memory_get_usage(true);

function maxSubsequenceFixedK(string $line, int $maxLength): string {
    $lengthLine = strlen($line);
    $result = '';
    $start = 0;
    for ($pos = 0; $pos < $maxLength; $pos++) {
        $end = $lengthLine - ($maxLength - $pos);
        $bestIdx = $start;
        $bestChar = $line[$start];
        for ($i = $start + 1; $i <= $end; $i++) {
            if ($line[$i] > $bestChar) {
                $bestChar = $line[$i];
                $bestIdx = $i;

                if ($bestChar === '9') break;
            }
        }
        $result .= $bestChar;
        $start = $bestIdx + 1;
    }

    return $result;
}

$lines = [
    "987654321111111",
    "2111111111111111119",
    "234234234234278",
    "818181911112111"
];

$k = 12;
$total = "0";
foreach ($batteriesBanks as $line) {
    $max = maxSubsequenceFixedK($line, $k);
    echo "$line => $max\n";
    $total = \bcadd($total, $max);
}
echo "Total exact: $total\n";
// Result : `167526011932478`

$endTime = microtime(true);
$endMemory = memory_get_usage(true);
$peakMemory = memory_get_peak_usage(true);

echo "Execution time: " . number_format(($endTime - $startTime), 6) . " s\n";
echo "Memory usage (current): " . $endMemory . " bytes\n";
echo "Peak memory usage: " . $peakMemory . " bytes\n";
