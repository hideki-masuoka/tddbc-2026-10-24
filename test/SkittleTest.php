<?php

declare(strict_types=1);

namespace Molkky\Tests;

use PHPUnit\Framework\TestCase;
use Molkky\Skittle;

final class SkittleTest extends TestCase
{
    public function test_1から12までの番号でスキットルを生成できる(): void
    {
        $skittle1 = new Skittle(1);
        $this->assertSame(1, $skittle1->getNumber());

        $skittle12 = new Skittle(12);
        $this->assertSame(12, $skittle12->getNumber());
    }

    public function test_1未満の番号の場合は例外が発生する(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Skittle(0);
    }

    public function test_12より大きい番号の場合は例外が発生する(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Skittle(13);
    }

    public function test_同じ番号のスキットルは等価と判定できる(): void
    {
        $skittleA = new Skittle(5);
        $skittleB = new Skittle(5);
        $skittleC = new Skittle(6);

        $this->assertTrue($skittleA->equals($skittleB));
        $this->assertFalse($skittleA->equals($skittleC));
    }
}
