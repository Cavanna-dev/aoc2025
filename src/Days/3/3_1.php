<?php

require __DIR__ . '/../../Common/fetchPuzzleInput.php';

$batteriesBanks = fetchAdventInput(3);

$startTime = microtime(true);
$startMemory = memory_get_usage(true);

$sumMaximumJoltage = 0;

foreach ($batteriesBanks as $batteriesBank) {
    $highest1 = 0;
    $highest2 = 0;

    $bankArray = str_split($batteriesBank);
    $elementCount = count($bankArray);

    foreach ($bankArray as $key => $char) {
        if ($char > $highest1 && $elementCount > $key + 1) {
            $highest2 = 0;
            $highest1 = $char;
        } elseif ($char > $highest2) {
            $highest2 = $char;
        }
    }
    $sumMaximumJoltage += $highest1 * 10 + $highest2;
}

$endTime = microtime(true);
$endMemory = memory_get_usage(true);
$peakMemory = memory_get_peak_usage(true);

echo "Result : `$sumMaximumJoltage`\n";
// Result : `16854`
echo "Execution time: " . number_format(($endTime - $startTime), 6) . " s\n";
echo "Memory usage (current): " . $endMemory . " bytes\n";
echo "Peak memory usage: " . $peakMemory . " bytes\n";
