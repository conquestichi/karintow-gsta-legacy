# B. データモデル（WP カスタム投稿タイプ + ACF）

新サイト（WordPress + SWELL + ACF Pro）におけるカスタム投稿タイプ・
カスタムタクソノミー・ACFフィールドグループの設計を記載します。

## B-1. 全体構成図

```
┌──────────────────┐          ┌──────────────────┐
│ CPT: event       │ ───┬───→ │ CPT: model       │
│ (カスタム投稿)   │    │      │ (カスタム投稿)   │
└──────────────────┘    │      └──────────────────┘
        │               │              ↑
        │               │              │
        ↓               │      ┌──────────────────┐
┌──────────────────┐    │      │ CPT: agency      │
│ Tax:             │    │      │ (事務所)         │
│ event_category   │    │      └──────────────────┘
└──────────────────┘    │
                        │      ┌──────────────────┐
                        └───→ │ CPT: venue        │
                               │ (開催場所)       │
                               └──────────────────┘

付属:
- WP標準: post (お知らせ)
- WP標準: page (固定ページ)
```

### 実装技術

- **カスタム投稿タイプ / タクソノミー登録**: プラグイン `Custom Post Type UI`
  - GUI で管理画面から追加可能
  - 将来のメンテもノーコードで対応
- **カスタムフィールド**: `ACF Pro` (Advanced Custom Fields Pro)
  - リレーション、リピーター、画像、日付等を豊富にサポート
- **テンプレート**: SWELL子テーマで `single-event.php` 等を自作

## B-2. CPT: event（イベント）

### 基本設定

| 項目 | 値 |
|---|---|
| Slug | `event` |
| Singular Label | イベント |
| Plural Label | イベント |
| Public | true |
| Has Archive | true |
| Rewrite Slug | `event` |
| Supports | title, editor, thumbnail, custom-fields, revisions |
| Menu Icon | `dashicons-calendar-alt` |

### ACFフィールドグループ: `event_details`

Location: Post Type == `event`

| フィールド名 | Name | Type | 必須 | 説明 |
|---|---|---|---|---|
| イベント名 | （投稿タイトル流用） | — | ✅ | WP標準タイトル |
| メインバナー | （アイキャッチ画像流用） | — | ✅ | WP標準サムネイル |
| ギャラリー | `gallery` | Gallery | | サブ画像複数 |
| 開催日 | `event_date` | Date Picker | ✅ | |
| 開催時刻（開始） | `start_time` | Time Picker | ✅ | |
| 開催時刻（終了） | `end_time` | Time Picker | ✅ | |
| 会場 | `venue` | Post Object (CPT: venue) | ✅ | |
| 出演モデル | `models` | Relationship (CPT: model) | | 複数選択 |
| 料金 | `price` | Text | ✅ | 自由記述 |
| 詳細説明 | （投稿本文流用） | — | ✅ | WP標準エディタ |
| 注意事項 | `notes` | WYSIWYG | | |
| 申込URL | `apply_url` | URL | | 外部フォーム or 内部 |
| ステータス | `event_status` | Select | ✅ | 予約受付中/満員/終了/中止 |
| TOP掲載 | `is_featured` | True/False | | |

### カスタムタクソノミー: `event_category`

| 項目 | 値 |
|---|---|
| Slug | `event_category` |
| Labels | イベントカテゴリ |
| Hierarchical | true |
| Rewrite Slug | `event/category` |
| Associate With | CPT `event` |

初期ターム（手動登録 5件）:
| Slug | 名前 | 説明 |
|---|---|---|
| `session` | セッション | 毎日17:00〜22:00、予約不要 |
| `sp` | SP撮影会 | スペシャルフォトセッション |
| `one` | 個撮 | 個人・団体撮影会、要予約 |
| `kikaku` | キカク | WJオーディション等 |
| `special` | スペシャル | プール貸切などの大型 |

## B-3. CPT: model（モデル）

### 基本設定

| 項目 | 値 |
|---|---|
| Slug | `model` |
| Singular Label | モデル |
| Plural Label | モデル |
| Public | true |
| Has Archive | true |
| Rewrite Slug | `model` |
| Supports | title, editor, thumbnail, custom-fields, revisions |
| Menu Icon | `dashicons-groups` |

### ACFフィールドグループ: `model_profile`

| フィールド名 | Name | Type | 必須 | 説明 |
|---|---|---|---|---|
| モデル名 | （投稿タイトル） | — | ✅ | |
| プロフィール写真 | （アイキャッチ） | — | ✅ | メイン縦長写真 |
| 丸サムネ用画像 | `thumbnail_round` | Image | ✅ | 正方形 |
| フリガナ | `name_kana` | Text | | 50音ソート用 |
| 所属事務所 | `agency` | Post Object (CPT: agency) | | フリーは空 |
| 自己紹介 | （投稿本文） | — | | WYSIWYG |
| Twitter URL | `twitter_url` | URL | | |
| Instagram URL | `instagram_url` | URL | | |
| 現役フラグ | `is_active` | True/False | ✅ | falseで非表示 |
| 表示順 | `display_order` | Number | | 手動調整用 |

### ⚠️ 肖像権・プライバシー

- 各モデルから掲載許諾を取得
- 引退時は `is_active = false` で即非表示
- 非表示時は `robots` メタ `noindex` を自動付与

## B-4. CPT: agency（事務所）

### 基本設定

| 項目 | 値 |
|---|---|
| Slug | `agency` |
| Public | ❓ Q10 要確認（フロント露出の要否） |
| Has Archive | ❓ |
| Supports | title, editor, thumbnail, custom-fields |

### ACFフィールドグループ: `agency_info`

| フィールド名 | Name | Type |
|---|---|---|
| 事務所名 | （投稿タイトル） | — |
| ロゴ | `logo` | Image |
| 公式サイトURL | `website_url` | URL |
| 説明 | （投稿本文） | — |

## B-5. CPT: venue（開催場所）

### 基本設定

| 項目 | 値 |
|---|---|
| Slug | `venue` |
| Public | false（管理画面内のみ、フロント個別ページ不要） |
| Supports | title, editor, thumbnail, custom-fields |

### ACFフィールドグループ: `venue_info`

| フィールド名 | Name | Type | 必須 |
|---|---|---|---|
| 会場名 | （投稿タイトル） | — | ✅ |
| 住所 | `address` | Text | ✅ |
| アクセス | `access` | Text | |
| Google Map埋込コード | `map_embed` | Textarea | |
| 会場写真 | （アイキャッチ） | — | |
| 収容人数 | `capacity` | Number | |
| 設備・注意事項 | （投稿本文） | — | |

### 初期データ

- Gスタ秋葉原（東京都台東区浅草橋5-3-2 秋葉原スクエアビル 4F）
- ❓ Q11: その他の常用会場（プール会場等）

## B-6. WP標準 `post` を「お知らせ」として流用

カスタム投稿タイプを増やさずに WP 標準の `post` をお知らせ用途に使う。

- URL: `/news/{slug}/`（パーマリンクで `/news/%postname%/` に設定）
- カテゴリ: お知らせ / 重要 / メンテナンス
- TOPへの最新3件表示は SWELL の投稿リストブロックで対応

❓ Q09: そもそも必要か（X連携で代替する案もあり）

## B-7. 固定ページ構成

WP標準の `page` で以下を作成：

- `/beginners/` — 初めての方へ
- `/access/` — アクセス
- `/apply/` — お申し込み
- `/contact/` — お問い合わせ（Contact Form 7）
- `/audition/` — モデル募集

## B-8. 旧データ → 新構造マッピング

| 現行WP（カスタム投稿タイプ） | 新サイト |
|---|---|
| モデル管理 | CPT `model` |
| 事務所管理 | CPT `agency` |
| 開催場所管理 | CPT `venue` |
| トップページ管理 | （廃止、SWELLメインビジュアル機能で代替） |
| メール管理 | （対象外、別管理） |
| `event/{ID}` 投稿 | CPT `event`（タクソノミー=該当カテゴリ） |
| `one/{ID}` 投稿 | CPT `event`（タクソノミー=`one`） |

### 移行手順の概要

詳細は `05-migration-plan.md` を参照。基本戦略：

1. **旧DBダンプが取れる場合**（root復旧時）: WordPress標準のエクスポート機能（WXR）で一括移行
2. **取れない場合**（現状）: GitHubリポジトリの旧HTML 270件を自動パース → WXR変換 → インポート

---

**未解決項目**: `00-questions.md` の Q05, Q06, Q07, Q08, Q09, Q10, Q11 を参照
