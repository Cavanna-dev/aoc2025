<?php

declare(strict_types=1);

namespace Tests\DayFive;

use Ccavanna\Aoc2025\AdventClient;
use Ccavanna\Aoc2025\DayFive\DayFive;
use Ccavanna\Aoc2025\DayFour\DayFour;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DayFiveTest extends TestCase
{
    private static array $dataFake = [];
    public function setUp(): void
    {
        self::$dataFake = file(__DIR__ . '/data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        parent::setUp();
    }

    public function testBuild(): void
    {
        // Act
        $sut = new DayFive(self::$dataFake);

        // Arrange
        self::assertSame(['3-5', '10-14', '16-20', '12-18'], $sut->freshIdRanges);
        self::assertSame(['1', '5', '8', '11', '17', '32'], $sut->availableIngredientIds);
    }

    public function testGetMinMaxForARange(): void
    {
        // Act
        $sut = new DayFive();

        // Arrange
        self::assertEquals(['1', '3'], $sut->getMinMaxForARange('1-3'));
        self::assertEquals(['74889598306375', '79559523144736'], $sut->getMinMaxForARange('74889598306375-79559523144736'));
    }

    public function testIsIngredientFresh(): void
    {
        // Act
        $sut = new DayFive();

        // Arrange
        self::assertTrue($sut->isIngredientFresh('1', '1', '3'));
        self::assertFalse($sut->isIngredientFresh('1', '2', '3'));
    }

    #[DataProvider('provideHowManyAvailableIngredientIdsAreFresh')]
    public function testHowManyAvailableIngredientIdsAreFresh(array $data, int $expected): void
    {
        // Act
        $sut = new DayFive($data);

        // Arrange
        self::assertEquals($expected, $sut->howManyAvailableIngredientIdsAreFresh());
    }

    public static function provideHowManyAvailableIngredientIdsAreFresh(): \Generator
    {
        $dataFake = file(__DIR__ . '/data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $dataReal = (new AdventClient())->fetchInput(5);

        yield 'fake' => [$dataFake, 3];
        yield 'real' => [$dataReal, 862];
    }

    public function testCountFreshInRange(): void
    {
        // Act
        $sut = new DayFive();

        // Arrange
        self::assertEquals(11, $sut->countFreshInRange('120', '130'));
        self::assertEquals(3, $sut->countFreshInRange('1', '3'));
    }

    public function testIterateRange(): void
    {
        // Act
        $sut = new DayFive();

        // Arrange
        $result = iterator_to_array($sut->iterateRange('1', '3'));
        self::assertEquals(['1', '2', '3'], $result);
    }

    #[DataProvider('provideSortIdRangesByMin')]
    public function testSortIdRangesByMin(array $data, array $expected): void
    {
        // Act
        $sut = new DayFive($data);
        $sut->sortIdRangesByMin();

        // Arrange
        self::assertEquals($expected, $sut->freshIdRanges);
    }

    public static function provideSortIdRangesByMin(): \Generator
    {
        yield [['1-3', '55-100', '120-210', '12-23', '70-80'], ['1-3', '12-23', '55-100', '70-80', '120-210']];
    }

    #[DataProvider('provideMergeOverlappingRanges')]
    public function testMergeOverlappingRanges(array $data, array $expected): void
    {
        // Act
        $sut = new DayFive($data);
        $sut->mergeOverlappingRanges();

        // Arrange
        self::assertEquals($expected, $sut->freshIdRanges);
    }

    public static function provideMergeOverlappingRanges(): \Generator
    {
        yield [['1-3', '2-5', '10-12', '55-100', '120-210', '12-23', '70-80'], ['1-5', '10-23', '55-100', '120-210']];
        yield [['3-5', '10-14', '16-20', '12-18'], ['3-5', '10-20']];
    }

    #[DataProvider('provideHowManyAvailableIngredientIdsAreFreshWithRanges')]
    public function testHowManyAvailableIngredientIdsAreFreshWithRanges(array $data, int $expected): void
    {
        // Act
        $sut = new DayFive($data);

        // Arrange
        self::assertEquals($expected, $sut->howManyAvailableIngredientIdsAreFreshOnlyWithRanges());
    }

    public static function provideHowManyAvailableIngredientIdsAreFreshWithRanges(): \Generator
    {
        $dataFake = file(__DIR__ . '/data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $dataReal = (new AdventClient())->fetchInput(5);

        yield 'fake' => [$dataFake, 14];
        yield 'real' => [$dataReal, 357907198933892];
    }
}
