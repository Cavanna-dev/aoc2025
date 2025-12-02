<?php

require __DIR__ . '/../../Common/fetchPuzzleInput.php';

$rotations = fetchAdventInput(1);

function countZeros(array $instructions, int $start = 50, int $max = 99): int {
    $pos = $start;
    $zeros = 0;

    foreach ($instructions as $line) {
        $line = trim($line);
        if ($line === '') continue;

        $dir = $line[0];
        $steps = (int)substr($line, 1);

        if ($dir === 'R') {
            $pos = ($pos + $steps) % ($max + 1);
        } elseif ($dir === 'L') {
            $pos = ($pos - $steps) % ($max + 1);
            if ($pos < 0) $pos += ($max + 1);
        } else {
            throw new RuntimeException("Direction inconnue: '{$dir}'");
        }

        if ($pos === 0) {
            $zeros++;
        }
    }

    return $zeros;
}

$result = countZeros($rotations);

echo "Result : `$result`\n";
// Result : `999`
