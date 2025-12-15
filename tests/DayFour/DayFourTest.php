<?php

declare(strict_types=1);

namespace Tests\DayFour;

use Ccavanna\Aoc2025\AdventClient;
use Ccavanna\Aoc2025\DayFour\DayFour;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DayFourTest extends TestCase
{
    private const string GRID = "..@@.@@@@.
@@@.@.@.@@
@@@@@.@.@@
@.@@@@..@.
@@.@@@@.@@
.@@@@@@@.@
.@.@.@.@@@
@.@@@.@@@@
.@@@@@@@@.
@.@.@@@.@.";

    #[DataProvider('provideGetValueData')]
    public function testBuildGrid(
        string $expected,
        int $actualX,
        int $actualY,
    ): void {
        // Arrange
        $grid = explode("\n", self::GRID);

        // Act
        $sut = new DayFour($grid);

        self::assertEquals($expected, $sut->getValue($actualX, $actualY));
    }

    public static function provideGetValueData(): \Generator
    {
        yield ['.', 0, 0];
        yield ['@', 0, 3];
        yield ['@', 2, 3];
    }

    #[DataProvider('provideIsRollData')]
    public function testIsRoll(bool $expected, string $actual): void
    {
        self::assertEquals($expected, DayFour::isRoll($actual));
    }

    public static function provideIsRollData(): \Generator
    {
        yield [false, '.'];
        yield [true, '@'];
    }

    #[DataProvider('provideGetNeighborsData')]
    public function testGetNeighbors(
        array $expected,
        int $actualX,
        int $actualY,
    ): void {
        // Arrange
        $grid = explode("\n", self::GRID);

        // Act
        $sut = new DayFour($grid);

        // Assert
        self::assertEquals($expected, $sut->getNeighbors($actualX, $actualY));
    }

    public static function provideGetNeighborsData(): \Generator
    {
        yield [['.', '@', '@'], 0, 0];
        yield [['@', '@', '.', '@', '@', '.', '@', '@'], 2, 2];
    }

    #[DataProvider('provideIsAccessibleData')]
    public function testIsAccessible(
        bool $expected,
        int $actualX,
        int $actualY,
    ): void {
        // Arrange
        $grid = explode("\n", self::GRID);

        // Act
        $sut = new DayFour($grid);

        // Assert
        self::assertEquals($expected, $sut->isAccessible($actualX, $actualY));
    }

    public static function provideIsAccessibleData(): \Generator
    {
        yield [true, 0, 2];
        yield [false, 2, 2];
        yield [true, 1, 0];
        yield [true, 7, 0];
    }

    #[DataProvider('provideCountHowManyRollsAreAccessibleData')]
    public function testCountHowManyRollsAreAccessible(array $data, int $expected): void
    {
        // Act
        $sut = new DayFour($data);

        // Assert
        self::assertEquals($expected, $sut->countHowManyRollsAreAccessible());
    }

    public static function provideCountHowManyRollsAreAccessibleData(): \Generator
    {
        yield 'fake' => [explode("\n", self::GRID), 13];
        yield 'real' => [(new AdventClient())->fetchInput(4), 1543];
    }

    public function testRemoveRollOfPaper(): void
    {
        // Arrange
        $data = explode("\n", self::GRID);

        // Act
        $sut = new DayFour($data);

        // Assert
        self::assertTrue(DayFour::isRoll($sut->getValue(0, 3)));

        $sut->removeRollOfPaper(0, 3);

        self::assertFalse(DayFour::isRoll($sut->getValue(0, 3)));
    }

    #[DataProvider('provideCountHowManyRollsCanBeRemoved')]
    public function testCountHowManyRollsCanBeRemoved(array $data, int $expected): void
    {
        // Act
        $sut = new DayFour($data);

        // Assert
        self::assertEquals($expected, $sut->countHowManyRollsCanBeRemoved());
    }

    public static function provideCountHowManyRollsCanBeRemoved(): \Generator
    {
        yield 'fake' => [explode("\n", self::GRID), 43];
        yield 'real' => [(new AdventClient())->fetchInput(4), 9038];
    }
}
