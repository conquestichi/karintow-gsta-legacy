# Gスタ撮影会 HP刷新プロジェクト 設計ドキュメント

最終更新: 2026-04-13
バージョン: v2.1 (デザイン方針確定版 — 白ベース×赤 / Freshインスパイア)

---

## このドキュメントについて

株式会社KARINTOWが運営する撮影会スタジオ「Gスタ撮影会」（studio-g.net）の
HP刷新プロジェクトにおける、システム全体の設計仕様書です。

現行WordPressサイト（さくらVPS / CentOS 7 / WP 4.9.26）から、
**新WordPress環境（ConoHa WING + SWELLテーマ）** への移行を前提に設計します。

## 構成

| # | ファイル | 内容 |
|---|---|---|
| 0 | [00-questions.md](./00-questions.md) | 要確認項目マスターリスト |
| A | [01-sitemap.md](./01-sitemap.md) | サイトマップ・ページ構成・ナビゲーション |
| B | [02-data-model.md](./02-data-model.md) | データモデル・カスタム投稿タイプ・ACF設計 |
| C | [03-operations.md](./03-operations.md) | 運用フロー・管理システム・担当分担 |
| D | [04-infrastructure.md](./04-infrastructure.md) | 技術スタック・インフラ・コスト |
| E | [05-migration-plan.md](./05-migration-plan.md) | 旧→新WP移行計画・データ移管手順 |
| F | [06-design-direction.md](./06-design-direction.md) | デザイン方針・カラー・タイポ・装飾 |

## ステータス記号

- ✅ 確定済み
- 🚧 進行中・部分的確定
- ⏸ 保留
- ❓ **要確認** （司令官・KARINTOW側からの情報待ち）
- 💡 提案・推奨
- ⚠️ 注意・リスクあり

## プロジェクト基本情報

- **クライアント**: 株式会社KARINTOW（自社案件）
- **サービス名**: Gスタ撮影会
- **現行HP**: https://studio-g.net/
- **新HP**: 構築予定（WordPress + SWELL on ConoHa WING）
- **システム保守**: 司令官
- **日常運用**: KARINTOW側スタッフ

## v2.0 変更履歴（v1.0 → v2.0）

**プラットフォーム転換**: Webflow → WordPress + SWELL

判断理由（詳細は `00-questions.md` の「案B選定経緯」参照）:
- **コスト**: Webflow $23-39/月 → ConoHa WING ¥941/月で安価
- **既存スキル**: KARINTOW担当者のWP経験を継承可能
- **ロックイン回避**: WP標準で長期保守性◎、いつでも移行可
- **構造的リスク回避**: 管理型ホスティングなのでroot喪失事故が起きない
- **データ移行**: 旧WPからの移行が劇的に楽（WP→WP）

Webflow構築済みサイト（ID: `69d1f22c1d19cda39fee4fec`）は廃止予定。

## v2.1 変更履歴（v2.0 → v2.1）

**デザイン方針の反転**: ダーク×赤・おじさん向け質実剛健 → **白ベース×赤・キレイかわいい**

- ブランド赤 `#d4002a` 確定
- 背景を白ベース `#ffffff` に変更
- 参考筆頭サイト: フレッシュ撮影会 (fresh-club.net) に切替
- 装飾方針: グラスモーフィズム → SVGオブジェクト散布
- 新規ファイル `06-design-direction.md` 追加
- ターゲット（中年男性）は変わらず、「モデルさんを可愛く魅せる場」として設計
