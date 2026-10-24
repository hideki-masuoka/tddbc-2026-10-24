<?php

declare(strict_types=1);

namespace Molkky\Tests;

use PHPUnit\Framework\TestCase;
use Molkky\ScoreSheet;
use Molkky\Skittle;
use Molkky\ThrowResult;

final class ScoreSheetTest extends TestCase
{
    public function test_初期状態では推移は空で現在の得点は0点である(): void
    {
        $sheet = new ScoreSheet();
        $this->assertSame(0, $sheet->getCurrentScore());
        $this->assertSame([], $sheet->getTransitions());
    }

    public function test_投擲を記録すると得点の推移を振り返ることができる(): void
    {
        $sheet = new ScoreSheet();
        $sheet->record(new ThrowResult(new Skittle(12)));
        $sheet->record(new ThrowResult(new Skittle(3), new Skittle(4))); // 2点獲得
        $sheet->record(new ThrowResult(new Skittle(8)));

        // 12点 -> 14点 -> 22点
        $this->assertSame([12, 14, 22], $sheet->getTransitions());
        $this->assertSame(22, $sheet->getCurrentScore());
    }

    public function test_投擲した特定の時点の得点を振り返ることができる(): void
    {
        $sheet = new ScoreSheet();
        $sheet->record(new ThrowResult(new Skittle(12)));
        $sheet->record(new ThrowResult(new Skittle(3), new Skittle(4)));
        $sheet->record(new ThrowResult(new Skittle(8)));

        $this->assertSame(12, $sheet->getScoreAt(1));
        $this->assertSame(14, $sheet->getScoreAt(2));
        $this->assertSame(22, $sheet->getScoreAt(3));
    }

    public function test_存在しない投擲時点を指定した場合は例外が発生する(): void
    {
        $sheet = new ScoreSheet();
        $sheet->record(new ThrowResult(new Skittle(5)));

        $this->expectException(\OutOfBoundsException::class);
        $sheet->getScoreAt(2);
    }
}
