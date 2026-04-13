# wp/

新サイト（WordPress + SWELL on ConoHa WING）向けの
カスタムコード置き場。

## 構成

```
wp/
├── themes/
│   └── karintow-child/   ← SWELL子テーマ（GitHub Actionsで自動デプロイ）
├── plugins/              ← 将来的な自作プラグイン（予定）
└── README.md
```

## 自動デプロイ

`main` ブランチへ push すると、`.github/workflows/deploy-wp.yml` が
`wp/themes/karintow-child/` を本番サーバーへ転送する。

デプロイ先・認証情報は GitHub Secrets で管理する。
詳細は `/docs/07-ci-cd.md` 参照。

## 除外されるもの

- `wp-config.php` / 認証情報ファイル（リポジトリ外で管理）
- WordPress 本体（親テーマ SWELL含む）
- `wp-content/uploads/` 配下の画像（肖像権のため別管理）
