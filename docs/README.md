# Gスタ撮影会 HP刷新プロジェクト 設計ドキュメント

最終更新: 2026-04-13
バージョン: v2.2 (CI/CD仕込み版)

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
| G | [07-ci-cd.md](./07-ci-cd.md) | CI/CD・GitHub Actions・自動デプロイ |

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

## リポジトリ構成

```
karintow-gsta-legacy/
├── docs/                          ← 設計ドキュメント（このフォルダ）
├── wp/
│   └── themes/
│       └── karintow-child/        ← SWELL子テーマ（自動デプロイ対象）
├── legacy/                        ← 旧サイトwgetミラー（既存HTMLはルート直下）
└── .github/workflows/
    ├── docs-check.yml             ← docs検証（即動作）
    └── deploy-wp.yml              ← 子テーマ自動デプロイ（Secrets待ち）
```

## 変更履歴

### v2.2 (2026-04-13): CI/CD仕込み
- `.github/workflows/docs-check.yml` 追加（docs検証、即動作）
- `.github/workflows/deploy-wp.yml` 追加（子テーマデプロイ、Secrets待ち）
- `wp/themes/karintow-child/` スケルトン作成
- `07-ci-cd.md` 追加

### v2.1 (2026-04-13): デザイン方針反転
- ダーク×赤・質実剛健 → **白ベース×赤・キレイかわいい**
- 参考筆頭: TIF2025 → **フレッシュ撮影会**
- 装飾方針: グラスモーフィズム → **SVGオブジェクト散布**
- `06-design-direction.md` 追加

### v2.0 (2026-04-13): プラットフォーム転換
- Webflow → **WordPress + SWELL + ConoHa WING**
- コスト削減（¥1,738 → ¥941/月）
- KARINTOW既存WPスキル継承
- `05-migration-plan.md` 追加
- Webflowサイト廃止予定

### v1.0 (2026-04-13): 初版
- Webflow前提で6章構成の設計docs作成
