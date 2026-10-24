<?php

declare(strict_types=1);

namespace Molkky;

/**
 * 1回の投擲結果を表すファーストクラスコレクション
 */
final readonly class ThrowResult
{
    /** @var list<Skittle> */
    private array $skittles;

    /**
     * @param Skittle ...$skittles 倒れたスキットル一覧
     * @throws \InvalidArgumentException 同じスキットルが重複して指定された場合
     */
    public function __construct(Skittle ...$skittles)
    {
        $seen = [];
        foreach ($skittles as $skittle) {
            $number = $skittle->getNumber();
            if (isset($seen[$number])) {
                throw new \InvalidArgumentException(
                    "スキットルは各番号1本ずつのため重複はできません: {$number}"
                );
            }
            $seen[$number] = true;
        }

        $this->skittles = array_values($skittles);
    }

    /**
     * 投擲によって得られる点数を計算する
     */
    public function getScore(): int
    {
        $count = count($this->skittles);

        // 1本だけ倒した場合は、スキットルの番号が得点になる
        if ($count === 1) {
            return $this->skittles[0]->getNumber();
        }

        // 2本以上倒した場合は、倒した本数が得点になる（0本の場合は0点）
        return $count;
    }
}
