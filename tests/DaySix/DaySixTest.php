<?php

declare(strict_types=1);

namespace Tests\DaySix;

use Ccavanna\Aoc2025\AdventClient;
use Ccavanna\Aoc2025\DaySix\DaySix;
use Ccavanna\Aoc2025\DaySix\Number;
use Ccavanna\Aoc2025\DaySix\Problem;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DaySixTest extends TestCase
{
    private static array $dataFake = [];
    public function setUp(): void
    {
        self::$dataFake = file(__DIR__ . '/data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        parent::setUp();
    }

    public function testBuildProblems(): void
    {
        // Act
        $sut = new DaySix(self::$dataFake);

        // Arrange
        self::assertEquals(
            [
                new Problem('*', ['123', '45', '6']),
                new Problem('+', ['328', '64', '98']),
                new Problem('*', ['51', '387', '215']),
                new Problem('+', ['64', '23', '314']),
            ],
            $sut->problems
        );
    }

    public function testResolveProblem(): void
    {
        $sut = new Problem('*', ['123', '45', '6']);
        self::assertEquals($sut->resolveProblem(), '33210');

        $sut = new Problem('+', ['328', '64', '98']);
        self::assertEquals($sut->resolveProblem(), '490');
    }

    #[DataProvider('provideProblems')]
    public function testResolveDaySix(array $input, string $expected): void
    {
        // Arrange
        $sut = new DaySix($input);

        // Assert
        self::assertSame($expected, $sut->countGrandTotalAllProblems());
    }

    public static function provideProblems(): \Generator
    {
        yield 'fake' => [file(__DIR__ . '/data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES), '4277556'];
        yield 'real' => [(new AdventClient())->fetchInput(6), '6378679666679'];
    }

    public function testNumber(): void
    {
        $sut = new Number(['1', ' ', ' ']);
        self::assertEquals($sut->getNumber(), '1');

        $sut = new Number(['2', '4', ' ']);
        self::assertEquals($sut->getNumber(), '24');

        $sut = new Number();
        $sut->addCharacter('2');
        $sut->addCharacter('4');
        self::assertEquals($sut->getNumber(), '24');

        $sut = new Number([' ', ' ', '4']);
        self::assertEquals($sut->getNumber(), '4');

        $sut = new Number(['1', ' ', '4', ' ']);
        self::assertEquals($sut->getNumber(), '14');
    }

    public function testBuildProblemsFromRight(): void
    {
        // Act
        $sut = new DaySix(self::$dataFake, true);

        // Arrange
        self::assertEquals(
            [
                new Problem('*', ['1', '24', '356']),
                new Problem('+', ['8', '248', '369']),
                new Problem('*', ['176', '581', '32']),
                new Problem('+', ['4', '431', '623']),
            ],
            $sut->problems
        );
    }
}
