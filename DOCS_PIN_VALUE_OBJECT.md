# TDD 実行記録: Pin バリューオブジェクトの導入

## 1. 目的と背景
- **ナビゲーターからの指示**: 「ピンをバリューオブジェクトにしてください」
- **狙い**: 
  - ピンの番号が `1〜12` であるというドメインルール・不変条件を `Pin` クラス自身に閉じ込め、プリミティブ型（`int`）の直接操作による不正値の混入を防ぐ。
  - 値の不変性（Immutable）と等価性（Equality）を保証する。

---

## 2. TDD 実行サイクル

### サイクル 1: Pin の責務と振る舞いの定義
- **Red (テスト作成)**:
  - `test/PinTest.php` を作成。
  - テストケース:
    1. `test_1から12までの番号でピンを生成できる`: 境界値 1, 12 で正常生成。
    2. `test_1未満の番号の場合は例外が発生する`: 0 を渡すと `InvalidArgumentException`。
    3. `test_12より大きい番号の場合は例外が発生する`: 13 を渡すと `InvalidArgumentException`。
    4. `test_同じ番号のピンは等価と判定できる`: 同一番号のピンの等価性（`equals`）確認。
  - 実行結果: `Class "Molkky\Pin" not found`（Red）。

- **Green (実装)**:
  - `src/Pin.php` を作成。
  - PHP 8.2+ の `final readonly class` として実装し、コンストラクタで 1〜12 の範囲検証を実施。
  - 実行結果: 全テスト通過（Green）。

### サイクル 2: 既存コードへの統合（リファクタリング）
- **Refactor**:
  - `src/Molkky.php` の `calculateScore()` 内で行っていた `if ($pin < 1 || $pin > 12)` の範囲チェックを削除。
  - 代わりに各要素に対して `new Pin($pinNumber)` を生成することで、バリデーション責務を `Pin` VO に委譲。
- **検証**:
  - `phpunit`: 全17テスト All Green。
  - `phpstan`: Level max でエラーゼロ（`[OK] No errors`）。

---

## 3. テスト実行結果 (`./vendor/bin/phpunit --testdox`)

```text
Molkky (Molkky\Tests\Molkky)
 ✔ 1本だけ倒した場合はその数字が得点になる 5
 ✔ 1本だけ倒した場合はその数字が得点になる 12
 ✔ 2本以上倒した場合は倒した本数が得点になる
 ✔ 3本倒した場合は 3点になる
 ✔ 1本も倒れなかった場合は 0点になる
 ✔ 1未満のピン番号が含まれる場合は例外が発生する
 ✔ 12より大きいピン番号が含まれる場合は例外が発生する
 ✔ 同じピン番号が重複している場合は例外が発生する

Pin (Molkky\Tests\Pin)
 ✔ 1から 12までの番号でピンを生成できる
 ✔ 1未満の番号の場合は例外が発生する
 ✔ 12より大きい番号の場合は例外が発生する
 ✔ 同じ番号のピンは等価と判定できる

Team (Molkky\Tests\Team)
 ✔ チーム作成時の初期得点は 0点である
 ✔ 1本だけ倒した場合そのピンの数字が得点に加算される
 ✔ 2本以上倒した場合倒した本数が得点に加算される
 ✔ 1本も倒せなかった場合は得点は変化しない
 ✔ 複数回投擲を繰り返した得点が合計される

OK (17 tests, 19 assertions)
```

---

## 4. 静的解析結果 (`./vendor/bin/phpstan analyse`)

```text
Note: Using configuration file phpstan.neon.
 [OK] No errors (Level: max)
```
