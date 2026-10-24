<?php

declare(strict_types=1);

namespace Molkky\Tests;

use PHPUnit\Framework\TestCase;
use Molkky\Team;

final class TeamTest extends TestCase
{
    public function test_チーム作成時の初期得点は0点である(): void
    {
        $team = new Team();
        $this->assertSame(0, $team->getScore());
    }

    public function test_1本だけ倒した場合そのピンの数字が得点に加算される(): void
    {
        $team = new Team();
        $team->throws([5]);
        $this->assertSame(5, $team->getScore());
    }

    public function test_2本以上倒した場合倒した本数が得点に加算される(): void
    {
        $team = new Team();
        $team->throws([3, 4]);
        $this->assertSame(2, $team->getScore());
    }

    public function test_1本も倒せなかった場合は得点は変化しない(): void
    {
        $team = new Team();
        $team->throws([]);
        $this->assertSame(0, $team->getScore());
    }

    public function test_複数回投擲を繰り返した得点が合計される(): void
    {
        $team = new Team();
        $team->throws([12]);
        $team->throws([3, 4]);
        $team->throws([8]);

        // 12 + 2 + 8 = 22点
        $this->assertSame(22, $team->getScore());
    }
}
