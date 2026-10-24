<?php

declare(strict_types=1);

namespace Molkky;

/**
 * 得点表（スコアシート）
 * 投擲結果を記録し、得点の推移を管理・照会する
 */
final class ScoreSheet
{
    /** @var list<int> 各投擲終了時点の累計得点履歴 */
    private array $transitions = [];

    /**
     * 投擲結果を記録する
     */
    public function record(ThrowResult $result): void
    {
        $currentScore = $this->getCurrentScore();
        $this->transitions[] = $currentScore + $result->getScore();
    }

    /**
     * 現在の最新得点を取得する
     */
    public function getCurrentScore(): int
    {
        if (empty($this->transitions)) {
            return 0;
        }

        return $this->transitions[array_key_last($this->transitions)];
    }

    /**
     * これまでの得点の推移（各投擲終了時点のスコア一覧）を取得する
     *
     * @return list<int>
     */
    public function getTransitions(): array
    {
        return $this->transitions;
    }

    /**
     * 特定の投擲時点（1回目、2回目...）の得点を振り返る
     *
     * @param int $turn 何回目の投擲か（1始まり）
     * @return int その時点の得点
     * @throws \OutOfBoundsException 指定された投擲時点の記録が存在しない場合
     */
    public function getScoreAt(int $turn): int
    {
        $index = $turn - 1;
        if (!isset($this->transitions[$index])) {
            throw new \OutOfBoundsException("指定された投擲時点の記録が存在しません: {$turn}投目");
        }

        return $this->transitions[$index];
    }
}

