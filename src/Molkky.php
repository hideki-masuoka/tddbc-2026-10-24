<?php

declare(strict_types=1);

namespace Molkky;

class Molkky
{
    /**
     * 倒れたスキットル（ピン）の番号一覧から得点を計算する
     *
     * @param int[] $pins 倒れたピンの番号一覧
     * @return int 獲得得点
     * @throws \InvalidArgumentException ピン番号が1〜12以外、または重複がある場合
     */
    public function calculateScore(array $pins): int
    {
        $uniquePins = [];
        foreach ($pins as $pin) {
            if ($pin < 1 || $pin > 12) {
                throw new \InvalidArgumentException("ピンの番号は1から12である必要があります: {$pin}");
            }
            if (isset($uniquePins[$pin])) {
                throw new \InvalidArgumentException("スキットルは各番号1本ずつのため重複はできません: {$pin}");
            }
            $uniquePins[$pin] = true;
        }

        $count = count($pins);

        // 1本だけ倒した場合は、ピンに書かれた数字が得点になる
        if ($count === 1) {
            return $pins[0];
        }

        // 2本以上倒した場合は、倒した本数が得点になる（0本の場合は0点）
        return $count;
    }
}
