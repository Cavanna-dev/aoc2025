<?php

declare(strict_types=1);

namespace Ccavanna\Aoc2025\DaySix;

class Number
{
    public array $characters = [];

    public function __construct(array $characters = [])
    {
        foreach ($characters as $character) {
            $this->addCharacter($character);
        }
    }

    public function addCharacter(string $character): void
    {
        $this->characters[] = $character;
    }

    public function isEmpty(): bool
    {
        foreach($this->characters as $character) {
            if (!empty($character)) {
                return false;
            }
        }

        return true;
    }

    public function getNumber(): string
    {
        if ($this->isEmpty()) {
            return '';
        }

        $characterConcat = '';
        foreach ($this->characters as $character) {
            if ($character !== ' ') {
                $characterConcat .= $character;
            }
        }

        return $characterConcat;
    }
}
