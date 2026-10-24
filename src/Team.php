<?php

declare(strict_types=1);

namespace Molkky;

class Team
{
    private ScoreSheet $scoreSheet;

    public function __construct()
    {
        $this->scoreSheet = new ScoreSheet();
    }

    /**
     * 現在の得点を取得する
     */
    public function getScore(): int
    {
        return $this->scoreSheet->getCurrentScore();
    }

    /**
     * 投擲を行い、得点表に記録する
     */
    public function throws(ThrowResult $result): void
    {
        $this->scoreSheet->record($result);
    }

    /**
     * 得点表（スコアシート）を取得する
     */
    public function getScoreSheet(): ScoreSheet
    {
        return $this->scoreSheet;
    }
}
