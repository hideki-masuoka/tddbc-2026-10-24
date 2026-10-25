# Mölkky Score Counter (TDDBC)

モルック（Mölkky）の投擲得点計算およびスコア管理を行う、TDD（テスト駆動開発）ベースのPHPプロジェクトです。  
ドメインモデル（値オブジェクト）の設計と Symfony TUI を利用したインタラクティブなゲーム実行に対応しています。

■ 演習

[TDDBC Sendai 11th - connpass](https://tddbc.connpass.com/event/407078/)

---

## 🎯 機能・ドメインルール

### 1. 投擲得点計算 (`ThrowResult`, `Skittle`)
- **スキットル (`Skittle`)**: 1〜12 の番号を持つピン（不正な番号や重複をバリデーション）。
- **1本のみ倒した場合**: そのピンに書かれた番号が得点。
- **2本以上倒した場合**: 倒れた本数がそのまま得点。
- **0本（ミス投擲）の場合**: 0点。

### 2. チーム得点管理 (`Team`)
- 初期得点は 0 点。
- 投擲を繰り返すことで得点が加算・集約。

### 3. スコアシート・履歴の振り返り (`ScoreSheet`)
- 過去の各投擲時点のスコア履歴を記録。
- 指定した投擲回数時点の得点を振り返り取得可能。

### 4. インタラクティブ CLI アプリ (`bin/molkky`)
- Symfony TUI を用いたターミナル UI で、実際の投擲記録や得点推移の確認が可能。

---

## 🛠 技術スタック

- **言語**: PHP 8.5+
- **テストフレームワーク**: PHPUnit 13.x
- **静的解析ツール**: PHPStan (Level: max)
- **UI コンポーネント**: Symfony TUI (`symfony/tui`)

---

## 🚀 環境構築・実行方法

### 依存関係のインストール

```bash
composer install
```

### テスト実行 (PHPUnit)

```bash
./vendor/bin/phpunit
```

### 静的コード解析 (PHPStan)

```bash
./vendor/bin/phpstan analyse
```

### TUI アプリケーションの起動

```bash
php bin/molkky
# または実行権限がある場合
./bin/molkky
```

#### TUI コマンド例:
- `5` : 5番ピンを倒した
- `3, 4` : 3番と4番ピンを倒した（2点）
- `Enter`（空文字）: ミス投擲（0点）
- `?1` : 第1投時点の得点を振り返る
- `q` または `exit` : 終了

---

## 📁 ディレクトリ構成

```text
├── bin/
│   └── molkky                 # Symfony TUI 実行スクリプト
├── src/
│   ├── Molkky.php             # モルック計算基本クラス
│   ├── ScoreSheet.php         # スコアシート・履歴管理
│   ├── Skittle.php            # スキットル値オブジェクト (1-12)
│   ├── Team.php               # チーム集計エンティティ
│   └── ThrowResult.php        # 投擲結果値オブジェクト
├── test/
│   ├── MolkkyTest.php
│   ├── ScoreSheetTest.php
│   ├── SkittleTest.php
│   ├── TeamTest.php
│   └── ThrowResultTest.php
├── phpstan.neon               # PHPStan 設定
├── phpunit.xml                # PHPUnit 設定
└── composer.json
```

---

## 📚 関連ドキュメント・開発記録

プロジェクト内の各マークダウンファイルと概要の一覧です。

| ドキュメント | 概要 |
| :--- | :--- |
| [`PROJECT_ANALYSIS.md`](PROJECT_ANALYSIS.md) | プロジェクト初期構成・環境の解析レポート |
| [`spec-step2.md`](spec-step2.md) | Step2（得点計算・チーム管理）の仕様メモ |
| [`TEST_SPEC_STEP2.md`](TEST_SPEC_STEP2.md) | Step2 のテストケース詳細仕様 |
| [`STEP2_SUMMARY.md`](STEP2_SUMMARY.md) | Step2 実装完了サマリー |
| [`spec-step3.md`](spec-step3.md) | Step3（得点推移・履歴の振り返り）の仕様メモ |
| [`STEP3_SUMMARY.md`](STEP3_SUMMARY.md) | Step3 実装完了サマリー |
| [`DOCS_THROW_RESULT.md`](DOCS_THROW_RESULT.md) | 投擲結果値オブジェクト（`ThrowResult`）の設計ドキュメント |
| [`DOCS_PIN_VALUE_OBJECT.md`](DOCS_PIN_VALUE_OBJECT.md) | スキットル値オブジェクト（`Skittle`）の設計・リファクタリング解説 |
| [`REFACTORING_SUMMARY.md`](REFACTORING_SUMMARY.md) | リファクタリング概要・ドメインモデル改善の記録 |
| [`RETROSPECTIVE.md`](RETROSPECTIVE.md) | ふりかえり（TDDの実践プロセス・学びのまとめ） |
| [`result.md`](result.md) | CLI開発セッションログ |

