<?php

declare(strict_types=1);

namespace Molkky\Tests;

use PHPUnit\Framework\TestCase;
use Molkky\Skittle;
use Molkky\ThrowResult;

final class ThrowResultTest extends TestCase
{
    public function test_1本だけ倒した場合はそのスキットルの数字が得点になる(): void
    {
        $result = new ThrowResult(new Skittle(5));
        $this->assertSame(5, $result->getScore());
    }

    public function test_2本以上倒した場合は倒した本数が得点になる(): void
    {
        $result = new ThrowResult(new Skittle(3), new Skittle(4));
        $this->assertSame(2, $result->getScore());
    }

    public function test_0本の場合は0点になる(): void
    {
        $result = new ThrowResult();
        $this->assertSame(0, $result->getScore());
    }

    public function test_同じスキットルが重複している場合は例外が発生する(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new ThrowResult(new Skittle(5), new Skittle(5));
    }
}
