<?php

declare(strict_types=1);

namespace Molkky;

class Team
{
    private int $score = 0;
    private Molkky $molkky;

    public function __construct()
    {
        $this->molkky = new Molkky();
    }

    /**
     * 現在の得点を取得する
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * 投擲を行い、倒れたピンに応じてスコアを加算する
     *
     * @param int[] $pins 倒れたピンの番号一覧
     */
    public function throws(array $pins): void
    {
        $this->score += $this->molkky->calculateScore($pins);
    }
}
