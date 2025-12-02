<?php

require __DIR__ . '/../../Common/fetchPuzzleInput.php';

$rotations = fetchAdventInput(1);

function countZerosDuringRotations(array $instructions, int $start = 50, int $max = 99): int {
    $pos = $start;
    $zeros = 0;

    foreach ($instructions as $line) {
        $line = trim($line);
        if ($line === '') continue;

        $dir = $line[0];
        $steps = (int)substr($line, 1);

        if ($dir === 'R') {
            for ($i = 1; $i <= $steps; $i++) {
                $pos = ($pos + 1) % ($max + 1);
                if ($pos === 0) $zeros++;
            }
        } elseif ($dir === 'L') {
            for ($i = 1; $i <= $steps; $i++) {
                $pos = ($pos - 1) % ($max + 1);
                if ($pos < 0) $pos += ($max + 1);
                if ($pos === 0) $zeros++;
            }
        } else {
            throw new RuntimeException("Direction inconnue: '{$dir}'");
        }
    }

    return $zeros;
}

$result = countZerosDuringRotations($rotations);

echo "Result : `$result`\n";
// Result : `6099`
