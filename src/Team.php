<?php

declare(strict_types=1);

namespace Molkky;

class Team
{
    private int $score = 0;

    /**
     * 現在の得点を取得する
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * 投擲を行い、倒れたピンに応じてスコアを加算する
     */
    public function throws(ThrowResult $result): void
    {
        $this->score += $result->getScore();
    }
}
