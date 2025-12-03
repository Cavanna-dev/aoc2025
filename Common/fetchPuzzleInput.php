<?php

function fetchAdventInput(int $day): array
{
    $ch = curl_init("https://adventofcode.com/2025/day/{$day}/input");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Cookie: session=53616c7465645f5fb694b924147e969fd589e5499e898237c84203f86dc8da8f0b1f8c5dc7b59082ab820fe62d1a29a1e94a37fec5db08400444f4670e24e490'
        ],
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        throw new RuntimeException("Erreur cURL : {$error}");
    }

    return array_filter(explode("\n", rtrim($response)), fn($line) => $line !== '');
}
