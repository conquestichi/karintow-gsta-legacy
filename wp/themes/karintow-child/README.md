# Karintow Child Theme

Gスタ撮影会 公式サイトのカスタム子テーマ。
親テーマとして [SWELL](https://swell-theme.com/) を使用する。

## 構成

```
karintow-child/
├── style.css       ← Theme Header + カスタムCSS
├── functions.php   ← フック・エンキュー
└── README.md       ← このファイル
```

Phase 3 で以下のテンプレートが追加される：

```
karintow-child/
├── front-page.php              ← トップページ
├── single-event.php            ← イベント詳細
├── archive-event.php           ← イベント一覧
├── taxonomy-event_category.php ← カテゴリ別
├── single-model.php            ← モデル詳細
├── archive-model.php           ← モデル一覧
├── assets/
│   ├── svg/                    ← SVG装飾オブジェクト
│   └── img/                    ← 子テーマ固有画像
└── inc/
    └── *.php                   ← 機能別の分割ファイル
```

## デプロイ

このディレクトリは GitHub Actions により、
`main` ブランチへの push 時に自動で本番サーバーへデプロイされる。

詳細は `/docs/07-ci-cd.md` 参照。

## 設計方針

デザイン仕様・カラー・タイポグラフィの詳細は
`/docs/06-design-direction.md` を参照。

## バージョン

0.1.0 — 初期スケルトン
