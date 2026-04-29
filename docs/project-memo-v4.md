# Gスタ HP刷新プロジェクト — プロジェクトメモ v4
## 最終更新: 2026-04-29 (HTMLプロトタイプ完成 + LocalWP/SWELL環境構築完了)

---

## 🎯 現在地

**Phase 1: 設計確定 → 完了**  
**Phase 2: ビジュアル試作 → 完了（v4プロトタイプ確定）**  
**Phase 3: SWELL子テーマ実装 → 着手可能状態**

---

## ⚡ 次のセッションでやること

1. **SWELL子テーマにv4デザインを移植**
   - `swell_child/` に style.css / functions.php / front-page.php / assets/ を構築
   - v4 HTMLプロトタイプのCSS・構造をSWELLテンプレートに分割配置
   - LocalWP（g.local）で実動作確認
2. **ACF Proインストール → CPT（event/model）の管理画面構築**
3. **カスタム投稿タイプ登録**（event / model / agency / venue）

### 次のセッション冒頭で伝えること
```
子テーマにv4デザインを移植開始。
LocalWPのサイトフォルダは
C:\Users\conqu\Local Sites\gsta\app\public\wp-content\themes\swell_child\
```

---

## ✅ 確定事項

### プラットフォーム
- **採用**: WordPress 6.9.4 + SWELL 2.16.0(¥17,600買切) + ConoHa WING ベーシック(¥941/月)
- **不採用**: Webflow（廃止予定）
- **ローカル環境**: LocalWP → `g.local` で稼働中
- **ConoHa**: 未契約。LocalWPで開発完了後に契約予定

### デザイン方針（v4確定）
- **背景**: 暖色和紙クリーム `#fdfaf4` / `#f8eede` / `#fbeae5` / `#fde2d3`
- **アクセント赤**: `#d4002a` (濃: `#a30020` / 深: `#5a000f`)
- **暖色パレット**:
  - コーラル `#ff6b55` / ピーチ `#ffb39a` / サーモン `#ff8a73`
  - ローズ `#e8809a` / ゴールド `#c9a961` / ゴールド淡 `#f4e6c4`
- **テキスト**: インク `#1f1814`（深ブラウン）/ 本文 `#5a4f47` / メタ `#9c8e82`
- **フォント**: Zen Kaku Gothic New (本文) + Outfit (英字) + Bodoni Moda (飾りセリフ)
- **トーン**: エディトリアル × かわいい × 写真主役
- **装飾**: グラスモーフィズム（ヘッダー/ヒーロー/時刻チップ/モバイルCTA）、SVG装飾散布、非対称border-radius
- **本文サイズ**: 17px (PC) / 16px (SP)、行間1.85

### ブランドガード
- **「フレッシュ」「Fresh」「フレッシュ撮影会」**: 競合に属するため使用厳禁
- ヒーローキャッチは "Your studio, your story." に確定
- 日本語キャッチ: "写真を、もっと自由に。撮りたい瞬間を、いつもの場所で。"

### CI/CD
- `.github/workflows/docs-check.yml`: 稼働中
- `.github/workflows/deploy-wp.yml`: Secrets待ち（6つ）
- 手順: `docs/07-ci-cd.md` 参照

### GitHubリポジトリ
- **URL**: https://github.com/conquestichi/karintow-gsta-legacy
- **公開設定**: Public
- **PAT**: 司令官メモ管理

---

## 📸 v4 HTMLプロトタイプ（完成）

### 制作経緯
v1（基本要素配置）→ v2（タイポ大胆化・Bodoni追加）→ v3（暖色マルチカラー・グラスモーフィズム・Fresh文言削除）→ v4（実写真5名+本物ロゴ埋め込み）

### v4の構成（全11セクション）
1. **ヘッダー**: グラスモーフィズム固定、本物ロゴ画像、EN+JP二段ナビ
2. **ヒーロー**: 写真主役（62%幅メイン+サイド2枚）、グラスカード重ねキャッチ、ゴールド回転ステッカー、縦書き装飾、Quick Info Bar
3. **マルキー**: 黒地流れテロップ
4. **明日のイベント**: 日付切替UI + イベントカード3枚（写真+グラス時刻チップ）
5. **月縦カレンダー**: 白フレーム内、日付52px大、今日赤下線、カテゴリ4色タグ
6. **カテゴリ5種**: 5色グラデカード、hover全面展開
7. **モデル（マガジン風）**: Vol bar + フィーチャー4枚縦長カード + 全員丸サムネグリッド
8. **モデル募集バナー**: ダーク×赤グラデ + ゴールドステッカー + 傾き写真
9. **News**: 3色カテゴリタグ + hover矢印
10. **Concept**: 2枚コラージュ + グラス吹き出し + 大判タイポ
11. **初めての方**: 3色グラデカード + Bodoniイタリック大数字
12. **アクセス**: 地図+情報2カラム + 脈動赤ピン
13. **フッター**: ダーク + 巨大透かし文字 + 白ロゴ
14. **モバイル固定CTA**: 電話+申し込み下部バー

### 使用素材（確保済み）
| 素材 | ファイル | 用途 |
|---|---|---|
| ロゴ（赤） | Gstudio_logo1022F.pdf → 300dpi抽出+トリミング | ヘッダー、フッター（白化） |
| ひな | ひな.jpg | ヒーローメイン、フィーチャーNo.01 |
| 南雲るい | 南雲るい.jpg | フィーチャーNo.02、コンセプトサブ |
| 可愛小鳥 | 可愛小鳥_５月4日アキバ女学院.jpg | ヒーローサイド、フィーチャーNo.03 |
| 杠ゆあ | 杠ゆあ.jpg | ヒーローサイド、フィーチャーNo.04 |
| 篠宮るい | 篠宮るい_5月27日.jpg | コンセプトメイン、オーディション |

### プロトタイプファイル
- `gsta-top-mock-v4-embedded.html` (9.6MB, base64全画像埋め込み自己完結版)
- v1〜v3も保存済み

---

## 🖥️ ローカル開発環境（構築完了）

### LocalWP
- **サイト名**: gsta
- **URL**: http://g.local
- **WP管理画面**: http://g.local/wp-admin/
- **WP Version**: 6.9.4
- **ユーザー**: admin / admin
- **サイトフォルダ**: `C:\Users\conqu\Local Sites\gsta\app\public\`
- **子テーマフォルダ**: `C:\Users\conqu\Local Sites\gsta\app\public\wp-content\themes\swell_child\`

### インストール済みテーマ
- SWELL 2.16.0（親テーマ）
- SWELL CHILD（子テーマ、**有効化済み**）

### WPカスタマイザー設定済み
- メインビジュアル: 非表示
- メインカラー: `#d4002a`（設定予定）

### 未インストールプラグイン（次セッションで導入）
- ACF Pro（年間ライセンス購入済み）
- Custom Post Type UI
- SEO SIMPLE PACK
- Contact Form 7
- UpdraftPlus
- SiteGuard
- User Role Editor

---

## 📚 設計ドキュメント（GitHub docs/配下）

| # | ファイル | 内容 |
|---|---|---|
| README | プロジェクト概要・変更履歴 |
| 00 | 要確認項目マスター |
| 01 | サイトマップ・TOP構成 |
| 02 | データモデル・CPT・ACF設計 |
| 03 | 運用フロー・権限設計 |
| 04 | インフラ・コスト試算 |
| 05 | 移行計画8 Phase |
| 06 | デザイン方針・カラー・タイポ |
| 07 | CI/CD・GitHub Actions・Secrets手順 |

---

## 🔴 残オープン質問（P0）

| # | 内容 | 主体 |
|---|---|---|
| Q03 | 廃止候補ページ確定（WJオーディション、近代麻雀水着祭、checklist） | KARINTOW確認 |
| Q04 | 旧URL保全方針 | KARINTOW確認 |

---

## 🟡 残オープン質問（P1、12件）

- Q13: 「初めての方」サブページ独立 vs TOPで完結
- Q14: NEWSセクションの必要性
- Q17: 申込フォーム方式
- Q05〜Q11, Q12, Q16: KARINTOW相談必要

---

## 🗂️ 旧サイト情報（保留中）

### さくらVPS（廃止予定）
- IP: `160.16.211.67` / root: 不明・永遠に保留
- WP本体: 4.9.26 / ownerowner: 編集者権限のみ

### 旧サイトミラー（GitHub保管済）
- HTML 613ページ / karintowテーマCSS/JS
- 画像401枚はローカルのみ（肖像権配慮でGitHubから除外）

---

## 🛠️ 技術的知見

### ロゴ抽出手順
- PyMuPDF(`fitz`)で300dpiレンダリング → PIL `ImageChops.difference`で余白トリミング
- PDFは9ページ構成（赤/黒/白 × 縦/横の各バリエーション）
- 赤横版: page0の座標(1300,90)-(2420,560)をcrop → trimで648×169px
- ヘッダー用PNG、フッター用は `filter:brightness(0) invert(1)` でCSS白化

### HTMLプロトタイプでの写真配布
- 外部ファイル参照だとローカルでパスが合わない問題が発生
- **解決**: 全画像をbase64 data URIとしてHTML内に埋め込み（9.6MB単一ファイル）
- Python: `base64.b64encode()` → `url('data:image/jpeg;base64,...')` に置換

### SWELL子テーマ
- 公式 `swell_child.zip` はSWELLマイページ（users.swell-theme.com）からダウンロード
- 親テーマ先→子テーマ後の順でアップロード、子テーマのみ有効化
- カスタマイズは子テーマ側の `style.css` / `functions.php` に記述

### LocalWP
- Windows版: localwp.comから無料ダウンロード
- サイト作成は「+ Create a new site」→ 名前/admin/admin → 約2分
- WPファイルは `C:\Users\conqu\Local Sites\{site}\app\public\` に配置

---

## 📋 プロジェクト基本情報（変更なし）
- クライアント: 株式会社KARINTOW
- サービス: Gスタ撮影会
- 所在地: 東京都台東区浅草橋5-3-2 秋葉原スクエアビル4F
- 連絡: 090-2146-4481 / gst.akiba@gmail.com
- 公式X: @gst_tokyo
- 現行HP: https://studio-g.net/
- システム保守: 司令官
- 日常運用: KARINTOW側スタッフ
- 旧開発会社: 連絡不能
- ターゲット: 中年男性写真愛好家層

---

## 🚫 ABANDONED / OBSOLETE
- 旧VPS root復旧 → 永遠に保留
- Webflow構築サイト（ID:69d1f22c1d19cda39fee4fec）→ 廃止予定
- Webflow MCP/Canva MCP連携自動化 → 不要
- ダーク背景デザイン案 → 白ベース暖色に確定転換
- ブランドカラー `#CC2E32` → 誤り、`#d4002a` に確定
- 純白 `#ffffff` ベース → 暖色クリーム `#fdfaf4` に進化
