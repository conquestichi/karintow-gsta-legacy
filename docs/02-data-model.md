# B. データモデル・CMSコレクション設計

新サイト（Webflow CMS）における各コレクションのフィールド定義と
リレーション設計を記載します。

## B-1. 全体ER図（概念）

```
┌──────────┐         ┌──────────┐         ┌──────────┐
│  Events  │ ──┬───→ │  Models  │ ←───┬── │ Agencies │
└──────────┘   │      └──────────┘     │   └──────────┘
     │         │           ↑           │
     ↓         │           │           │
┌──────────┐   │      ┌──────────┐    │
│Categories│   └────→ │  Venues  │    │
└──────────┘          └──────────┘    │
                                      │
                      ┌──────────┐    │
                      │  News    │    │
                      └──────────┘    │
                                      │
        ┌─────────────────────────────┘
        │
   多対多リレーション
```

主要コレクション:
1. Events（イベント） — メイン
2. Categories（カテゴリ）
3. Models（モデル）
4. Agencies（事務所）
5. Venues（会場）
6. News（お知らせ）

## B-2. Events コレクション

### フィールド定義

| フィールド名 | 型 | 必須 | 説明 |
|---|---|---|---|
| Name | Plain Text | ✅ | イベント名 (例: "SPLASH SUMMER #すぶさま") |
| Slug | Slug | ✅ | URL用識別子 |
| Main Banner | Image | ✅ | メインバナー画像（Webflow CMS） |
| Gallery | Multi-Image | | サブ画像（最大10枚） |
| Category | Reference → Categories | ✅ | カテゴリ |
| Models | Multi-Reference → Models | | 出演モデル |
| Venue | Reference → Venues | ✅ | 開催会場 |
| Event Date | Date/Time | ✅ | 開催日 |
| Start Time | Plain Text | ✅ | 開始時刻 (例: "13:00") |
| End Time | Plain Text | ✅ | 終了時刻 (例: "18:00") |
| Price | Plain Text | ✅ | 料金（自由記述で枠/単価併記可能に）|
| Description | Rich Text | ✅ | 詳細本文 |
| Notes | Rich Text | | 注意事項・持ち物等 |
| Apply URL | Link | | 申込フォームURL（外部 or 内部） |
| Status | Option | ✅ | `予約受付中` / `満員` / `終了` / `中止` |
| Featured | Switch | | TOP掲載フラグ |
| Created Date | Date/Time | ✅ | 自動 |
| Updated Date | Date/Time | ✅ | 自動 |

### ❓ 要確認事項

- 料金は単一の文字列で十分か、複数枠（早割/通常/当日）を構造化すべきか
- 1イベントに複数開催日（連日）はあるか → ある場合は別レコードに分割
- イベントの定員数フィールドは必要か
- キャンセル待ちの仕組みは必要か

## B-3. Categories コレクション

### フィールド定義

| フィールド名 | 型 | 必須 | 説明 |
|---|---|---|---|
| Name | Plain Text | ✅ | カテゴリ名 |
| Slug | Slug | ✅ | URL用 |
| Description | Plain Text | | カテゴリ説明 |
| Icon Color | Color | | カテゴリ識別色 |
| Display Order | Number | ✅ | 表示順 |

### 初期データ（5件、固定）

| Slug | Name | 説明 |
|---|---|---|
| `session` | セッション | 毎日17:00〜22:00、予約不要のフリー撮影 |
| `sp` | SP撮影会 | スペシャルフォトセッション |
| `one` | 個撮 | 個人・団体撮影会、要予約 |
| `kikaku` | キカク | WJオーディション等の企画系 |
| `special` | スペシャル | プール貸切などの大型イベント |

## B-4. Models コレクション

### フィールド定義

| フィールド名 | 型 | 必須 | 説明 |
|---|---|---|---|
| Name | Plain Text | ✅ | モデル名（表示名） |
| Name Kana | Plain Text | | フリガナ（50音ソート用） |
| Slug | Slug | ✅ | URL用 |
| Profile Image | Image | ✅ | プロフィール写真（縦長推奨） |
| Thumbnail | Image | ✅ | 丸サムネ用（正方形） |
| Gallery | Multi-Image | | 過去の作品ギャラリー |
| Agency | Reference → Agencies | | 所属事務所（フリーランスの場合は空） |
| Bio | Rich Text | | 自己紹介・プロフィール |
| Twitter URL | Link | | X (Twitter) アカウント |
| Instagram URL | Link | | Instagramアカウント |
| Active | Switch | ✅ | 現役/引退フラグ（false=非表示） |
| Display Order | Number | | 表示順（手動調整用） |

### ⚠️ 肖像権・プライバシー注意事項

- 各モデルから掲載許諾を取ること
- 引退時はActive=falseで即座に非表示にできる運用
- 検索エンジンに引退モデルがインデックスされないよう、`noindex`設定を併用

## B-5. Agencies コレクション

### フィールド定義

| フィールド名 | 型 | 必須 | 説明 |
|---|---|---|---|
| Name | Plain Text | ✅ | 事務所名 |
| Slug | Slug | ✅ | URL用 |
| Logo | Image | | ロゴ画像 |
| Website | Link | | 公式サイトURL |
| Description | Plain Text | | 説明 |

### ❓ 要確認

- 現行サイトに「事務所管理」カスタム投稿タイプがあるが、フロントに事務所一覧ページは必要か？
- 所属モデルの絞り込みフィルタとしてのみ使うのか

## B-6. Venues コレクション

### フィールド定義

| フィールド名 | 型 | 必須 | 説明 |
|---|---|---|---|
| Name | Plain Text | ✅ | 会場名 |
| Slug | Slug | ✅ | URL用 |
| Address | Plain Text | ✅ | 住所 |
| Access | Plain Text | | アクセス情報（最寄駅徒歩○分等） |
| Map Embed | Plain Text | | Google Map埋め込みコード or 緯度経度 |
| Image | Image | | 会場写真 |
| Capacity | Number | | 収容人数 |
| Notes | Rich Text | | 設備・注意事項 |

### 初期データ（最低限）

- Gスタ秋葉原（メイン: 東京都台東区浅草橋5-3-2 秋葉原スクエアビル 4F）
- ❓ 他の常用会場（プール会場等）

## B-7. News コレクション

### フィールド定義

| フィールド名 | 型 | 必須 | 説明 |
|---|---|---|---|
| Title | Plain Text | ✅ | お知らせタイトル |
| Slug | Slug | ✅ | URL用 |
| Body | Rich Text | ✅ | 本文 |
| Published Date | Date/Time | ✅ | 公開日 |
| Category | Option | | `お知らせ` / `重要` / `メンテナンス` |
| Featured | Switch | | TOP掲載フラグ |

### ❓ 要確認

- そもそもNewsコレクションは必要か（X連携で代替する案もあり）

## B-8. 既存データ移行マッピング

現行WordPressからの移行対応：

| 現行WP（カスタム投稿タイプ） | 新サイト（CMS Collection） |
|---|---|
| モデル管理 | Models |
| 事務所管理 | Agencies |
| 開催場所管理 | Venues |
| トップページ管理 | （管理不要、Webflow Designerで直接編集） |
| メール管理 | （対象外、運用に移管） |
| event/{ID} 投稿 | Events（Category=該当カテゴリ） |
| one/{ID} 投稿 | Events（Category=個撮） |

### 移行手順（概要）

1. 現行HTMLから情報をパース → CSV化
2. CSVをWebflow CMS Importerでインポート
3. リレーションフィールド（Models、Venue等）は事前にマスタ登録
4. 画像は別途アップロード後にURLマッピング

詳細手順は `04-infrastructure.md` 参照。

---

**次のアクション**:
- ❓ Eventsの料金構造の決定（単一文字列 or 構造化）
- ❓ NewsコレクションのYes/No
- ❓ Venuesの初期データ収集
- ❓ Agenciesのフロント露出方針
