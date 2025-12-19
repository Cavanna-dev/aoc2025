<?php

declare(strict_types=1);

namespace Ccavanna\Aoc2025\DaySix;

class Problem
{
    private const string PLUS = '+';
    private const string TIME = '*';
    public ?string $operator;
    public array $operands = [];

    public function __construct(string $operator = null, array $operands = [])
    {
        $this->operator = $operator;

        foreach ($operands as $operand) {
            $this->addOperand($operand);
        }
    }

    public function setOperator(string $operator): void
    {
        $this->operator = $operator;
    }

    public function addOperand(string $operand): void
    {
        $this->operands[] = $operand;
    }

    public function resolveProblem(): string
    {
        if ($this->operator === self::PLUS) {
            $result = '0';
            foreach ($this->operands as $operand) {
                $result = bcadd($result, $operand);
            }
            return $result;
        }

        if ($this->operator === self::TIME) {
            $result = '1';
            foreach ($this->operands as $operand) {
                $result = bcmul($result, $operand);
            }
            return $result;
        }
    }
}
