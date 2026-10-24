# Step 3 実装記録: 得点の推移を確認する

## 1. 概要
`spec-step3.md` に基づき、投擲ごとの得点推移を振り返る機能を TDD で設計・実装しました。
`Team` の責務肥大化を防ぎ、単一責任の原則に従うため、得点と履歴の管理を担う **`ScoreSheet`（得点表）** オブジェクトを導入しました。

---

## 2. 仕様の充足状況（spec-step3.md）

- [x] **得点の推移**
  - [x] **推移を振り返ることができる**:
    - `ScoreSheet::getTransitions(): array` により、投擲ごとの累計得点推移（例: `[12, 14, 22]`）を取得可能。
  - [x] **投擲した時点の得点を振り返ることができる**:
    - `ScoreSheet::getScoreAt(int $turn): int` により、指定した投擲回（1投目、2投目...）の時点での得点を照会可能。

---

## 3. クラス設計と責務

| クラス | 種別 | 責務 |
| :--- | :--- | :--- |
| **`Skittle`** | Value Object | スキットル単体（1〜12の範囲保証、不変性、等価性） |
| **`ThrowResult`** | First Class Collection | 1回の投擲結果（同一投擲内での重複排除、投擲得点計算） |
| **`ScoreSheet`** | Domain Model | **得点表（投擲結果の記録、累計得点推移の管理、特定時点の得点照会）** |
| **`Team`** | Domain Entity | チーム（`ScoreSheet` を保持し、投擲の記録・最新得点の照会を委譲） |

---

## 4. 利用コード例

```php
$team = new Team();

// 投擲の実行
$team->throws(new ThrowResult(new Skittle(12)));
$team->throws(new ThrowResult(new Skittle(3), new Skittle(4))); // 2点獲得
$team->throws(new ThrowResult(new Skittle(8)));

// 1. 最新の得点
echo $team->getScore(); // 22

// 2. 得点表から推移を振り返る
$sheet = $team->getScoreSheet();
print_r($sheet->getTransitions());
// Array ( [0] => 12, [1] => 14, [2] => 22 )

// 3. 投擲した時点の得点を振り返る
echo $sheet->getScoreAt(1); // 12点（第1投時点）
echo $sheet->getScoreAt(2); // 14点（第2投時点）
echo $sheet->getScoreAt(3); // 22点（第3投時点）
```

---

## 5. テスト・静的解析の実行結果

### PHPUnit (`./vendor/bin/phpunit --testdox`)
```text
Score Sheet (Molkky\Tests\ScoreSheet)
 ✔ 初期状態では推移は空で現在の得点は 0点である
 ✔ 投擲を記録すると得点の推移を振り返ることができる
 ✔ 投擲した特定の時点の得点を振り返ることができる
 ✔ 存在しない投擲時点を指定した場合は例外が発生する

Skittle (Molkky\Tests\Skittle)
 ✔ 1から 12までの番号でスキットルを生成できる
 ✔ 1未満の番号の場合は例外が発生する
 ✔ 12より大きい番号の場合は例外が発生する
 ✔ 同じ番号のスキットルは等価と判定できる

Team (Molkky\Tests\Team)
 ✔ チーム作成時の初期得点は 0点である
 ✔ 1本だけ倒した場合そのスキットルの数字が得点に加算される
 ✔ 2本以上倒した場合倒した本数が得点に加算される
 ✔ 1本も倒せなかった場合は得点は変化しない
 ✔ 複数回投擲を繰り返した得点が合計される
 ✔ チームの得点表から得点の推移を振り返ることができる

Throw Result (Molkky\Tests\ThrowResult)
 ✔ 1本だけ倒した場合はそのスキットルの数字が得点になる
 ✔ 2本以上倒した場合は倒した本数が得点になる
 ✔ 0本の場合は 0点になる
 ✔ 同じスキットルが重複している場合は例外が発生する

OK (18 tests, 26 assertions)
```

### PHPStan (`./vendor/bin/phpstan analyse`)
```text
Note: Using configuration file phpstan.neon.
 [OK] No errors (Level: max)
```
