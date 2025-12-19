<?php

declare(strict_types=1);

namespace Ccavanna\Aoc2025\DaySix;

class DaySix
{
    /** @var Problem[] */
    public array $problems = [];
    public function __construct(array $input = [], bool $partTwo = false)
    {
        if ($partTwo === false) {
            $this->buildProblems($input);
        } else {
            $this->buildProblemsFromRight($input);
        }
    }

    public function buildProblems(array $input): void
    {
        $problems = [];
        $problemNumber = 0;
        foreach ($input as $rowKey => $rowValue) {

            foreach (explode(' ', $rowValue) as $columnValue) {
                if (empty($columnValue)) {
                    continue;
                }

                if (!isset($problems[$problemNumber])) {
                    $problems[$problemNumber] = new Problem();
                }

                if ($rowKey === array_key_last($input)) {
                    $problems[$problemNumber]->setOperator($columnValue);

                    $problemNumber++;
                    continue;
                }

                $problems[$problemNumber]->addOperand($columnValue);
                $problemNumber++;
            }

            $problemNumber = 0;
        }

        $this->problems = $problems;
    }

    public function buildProblemsFromRight(array $input): void
    {
        $problems = [];
        $problemNumber = 0;
        $numbers = [];
        foreach ($input as $rowKey => $rowValue) {

            $previousColumnValue = '';
            foreach (str_split($rowValue) as $columnKey => $columnValue) {
                if ($rowKey === array_key_last($input)) {
                    if ($columnValue !== ' ') {
                        $problems[$problemNumber]->setOperator($columnValue);
                    }

                    if (isset($numbers[$problemNumber][$columnKey])) {
                        $problems[$problemNumber]->addOperand($numbers[$problemNumber][$columnKey]->getNumber());
                    }

                    continue;
                }

                if ($columnValue === ' ') {
                    $previousColumnValue = $columnValue;
                    continue;
                }

                if ($previousColumnValue === ' ') {
                    $previousColumnValue = $columnValue;
                    $problemNumber++;
                }

                if (!isset($problems[$problemNumber])) {
                    $problems[$problemNumber] = new Problem();
                }

                if (!isset($numbers[$problemNumber][$columnKey])) {
                    $numbers[$problemNumber][$columnKey] = new Number();
                    var_dump('create number');
                }
                var_dump($numbers[$problemNumber][$columnKey], $problemNumber, $columnValue);
                $numbers[$problemNumber][$columnKey]->addCharacter($columnValue);
            }
            $problemNumber = 0;
        }

        $this->problems = $problems;
    }

    public function countGrandTotalAllProblems(): string
    {
        $problemsTotal = '0';
        foreach ($this->problems as $problem) {
            $problemsTotal = bcadd($problemsTotal, $problem->resolveProblem());
        }

        return $problemsTotal;
    }
}
