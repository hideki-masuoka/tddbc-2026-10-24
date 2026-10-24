<?php

declare(strict_types=1);

namespace Molkky\Tests;

use PHPUnit\Framework\TestCase;
use Molkky\Molkky;

final class MolkkyTest extends TestCase
{
    public function test_1本だけ倒した場合はその数字が得点になる_5(): void
    {
        $molkky = new Molkky();
        $score = $molkky->calculateScore([5]);
        $this->assertSame(5, $score);
    }

    public function test_1本だけ倒した場合はその数字が得点になる_12(): void
    {
        $molkky = new Molkky();
        $score = $molkky->calculateScore([12]);
        $this->assertSame(12, $score);
    }

    public function test_2本以上倒した場合は倒した本数が得点になる(): void
    {
        $molkky = new Molkky();
        $score = $molkky->calculateScore([3, 4]);
        $this->assertSame(2, $score);
    }

    public function test_3本倒した場合は3点になる(): void
    {
        $molkky = new Molkky();
        $score = $molkky->calculateScore([1, 2, 5]);
        $this->assertSame(3, $score);
    }

    public function test_1本も倒れなかった場合は0点になる(): void
    {
        $molkky = new Molkky();
        $score = $molkky->calculateScore([]);
        $this->assertSame(0, $score);
    }

    public function test_1未満のピン番号が含まれる場合は例外が発生する(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $molkky = new Molkky();
        $molkky->calculateScore([0]);
    }

    public function test_12より大きいピン番号が含まれる場合は例外が発生する(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $molkky = new Molkky();
        $molkky->calculateScore([13]);
    }

    public function test_同じピン番号が重複している場合は例外が発生する(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $molkky = new Molkky();
        $molkky->calculateScore([5, 5]);
    }
}
