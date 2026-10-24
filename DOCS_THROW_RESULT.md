# TDD 実行記録: ThrowResult（ファーストクラスコレクション）の導入

## 1. 課題と設計の動機
- **課題**: 
  - `Pin` バリューオブジェクト導入後、`Team::throws` に渡す引数をどうすべきか。
  - 1回の投擲における「同一ピンの重複不可」というルールをどこで担保すべきか。
- **解決策 (パターンC)**:
  - 1回の投擲結果を表すファーストクラスコレクション **`ThrowResult`** を導入。
  - 「ピンの重複チェック」および「1回の投擲における得点計算ルール」を `ThrowResult` に集約。

---

## 2. 実装クラスと責務の分離

| クラス | 責務 | 保証する不変条件（ルール） |
| :--- | :--- | :--- |
| **`Pin`** | ピン単体を表す VO | 1〜12 の範囲内であること |
| **`ThrowResult`** | 1回の投擲結果を表すファーストクラスコレクション | 重複ピンが存在しないこと、投擲の得点計算 |
| **`Team`** | チームとゲーム進行 | 投擲結果を受け取り、累計スコアに合算すること |

---

## 3. コード例（実際の使用イメージ）

```php
// 1本倒した場合（12番ピン → 12点）
$team->throws(new ThrowResult(new Pin(12)));

// 複数本倒した場合（3番と4番 → 2点）
$team->throws(new ThrowResult(new Pin(3), new Pin(4)));

// ミス（0点）
$team->throws(new ThrowResult());

// 重複ピンを渡そうとすると例外！
new ThrowResult(new Pin(5), new Pin(5)); // => InvalidArgumentException
```

---

## 4. TDD サイクルと結果
1. **Red**: `test/ThrowResultTest.php` を作成（未定義エラーを確認）。
2. **Green**: `src/ThrowResult.php` を実装し全ケース通過。
3. **Refactor**: `Team::throws` で `ThrowResult` を受け取れるように拡張。
4. **検証**:
   - PHPUnit: 全22テスト All Green！
   - PHPStan: Level max エラーゼロ（`[OK] No errors`）！
