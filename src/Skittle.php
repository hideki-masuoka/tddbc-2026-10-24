<?php

declare(strict_types=1);

namespace Molkky;

/**
 * モルックのスキットル（木製のピン）を表す Value Object
 */
final readonly class Skittle
{
    public const MIN_NUMBER = 1;
    public const MAX_NUMBER = 12;

    public function __construct(
        private int $number
    ) {
        if ($this->number < self::MIN_NUMBER || $this->number > self::MAX_NUMBER) {
            throw new \InvalidArgumentException(
                sprintf('スキットルの番号は%dから%dである必要があります: %d', self::MIN_NUMBER, self::MAX_NUMBER, $this->number)
            );
        }
    }

    /**
     * スキットルの番号を取得する
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * 別のスキットルと等価かどうかを判定する
     */
    public function equals(self $other): bool
    {
        return $this->number === $other->number;
    }
}
