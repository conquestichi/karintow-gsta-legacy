# E. 移行計画（旧→新WordPress）

旧サイト（さくらVPS上のWP 4.9.26）から新サイト（ConoHa WING上のWP 6.x + SWELL）への
データ移行戦略と段階的手順を定義します。

## E-1. 移行戦略の基本方針

### 大前提

**現状、旧WPのDBには一切アクセスできない**（root復旧せず）。
そのため、GitHubリポジトリ `karintow-gsta-legacy` に wget ミラーとして保存した
**HTMLファイル群をパースして、新WPに取り込む** 戦略を採用する。

### 移行対象データ

| カテゴリ | 件数 | 状態 |
|---|---|---|
| `/event/{ID}/` HTML | 約150件 | ✅ GitHub取得済 |
| `/one/{ID}/` HTML | 約120件 | ✅ GitHub取得済 |
| 固定ページHTML | 5件程度 | ✅ GitHub取得済 |
| 投稿画像 | 401枚 | ⏸ ローカルにのみ保管、選別後に新環境アップロード |

### 移行できないデータ

- ユーザーコメント（wgetで取得した限り、生HTMLには表示されているが信頼性なし）
- 旧WPユーザー情報
- プラグイン固有の設定データ
- ウィジェット配置

これらは新サイトで手動再設定する。

## E-2. Phase 1: 新環境準備

**期間目安**: 1〜2日

1. **ConoHa WING契約・ドメイン設定**
   - WINGパック ベーシック契約
   - ドメインは一時的に ConoHa サブドメイン or テスト用ドメイン
   - 本番ドメイン `studio-g.net` は Phase 6 まで旧サーバーに向けたまま
2. **WordPress インストール**
   - 管理者アカウント作成（強パスワード）
   - PHP 8.x 確認
3. **SWELL導入**
   - 購入・アカウント認証
   - 親テーマ + 子テーマ有効化
4. **基本プラグイン導入**
   - ACF Pro, Custom Post Type UI, SEO SIMPLE PACK, SiteGuard WP Plugin, Contact Form 7, UpdraftPlus, User Role Editor

## E-3. Phase 2: CPT・ACF構造構築

**期間目安**: 半日

1. Custom Post Type UI で `event`, `model`, `agency`, `venue` を登録
2. カスタムタクソノミー `event_category` を登録し、初期ターム5種を手動投入
3. ACF Pro でフィールドグループ `event_details`, `model_profile`, `agency_info`, `venue_info` を作成
4. WP管理画面で動作確認（空の状態でCPT追加画面が正しく表示されるか）

## E-4. Phase 3: マスタデータ先行登録

**期間目安**: 1日

**マスタ系はリレーション先なので、イベントより先に入れる**。

1. **venue**（開催場所）
   - Gスタ秋葉原を手動登録
   - ❓ Q11 で確定した他会場も登録
2. **agency**（事務所）
   - KARINTOW側から事務所リスト取得 → 手動登録
3. **model**（モデル）
   - 肖像権許諾が取れたモデルから優先登録
   - GitHubリポジトリの旧HTMLから名前を抽出してリスト化（補助）
   - 写真は新規撮り下ろし or 既存素材を再確認

## E-5. Phase 4: イベントデータ自動パース→WXR生成

**期間目安**: 2〜3日（自動化スクリプト作成 + 動作確認）

### アプローチ

GitHubリポジトリの `event/*/index.html` および `one/*/index.html` を自動パースし、
WordPress標準インポート形式である **WXR (WordPress eXtended RSS)** に変換する。

### 自動処理フロー

```
[GitHub Repo]
  ├─ event/27397/index.html
  ├─ event/27343/index.html
  └─ ...
        │
        │ Pythonパーサー
        │ (BeautifulSoup4)
        ↓
[中間CSV]
  title, date, category, content, banner_url, models(semicolon-sep)
        │
        │ WXRコンバーター
        ↓
[import.xml]
  WordPress WXR 形式
        │
        │ 新WP: ツール > インポート > WordPress
        ↓
[新WordPressに投入]
```

### パースで抽出するデータ

1. `<title>` → イベント名
2. `#single_title_area .post_date` → 開催日（年月日を組み立て）
3. `#post_title` → タイトル（`<title>`と照合）
4. `.meta li.post_category` → カテゴリ名
5. `#post_contents` → 本文HTML（整形）
6. `.post_image img` → メインバナー画像URL
7. 本文内の `.post img` → ギャラリー画像URL
8. 本文中のモデル名らしきパターン → 候補抽出（ACFリレーションは人手で再結線）

### 出力されるWXR構造（例）

```xml
<item>
  <title>SPLASH SUMMER #すぶさま</title>
  <wp:post_type>event</wp:post_type>
  <wp:post_name>27397</wp:post_name>
  <wp:status>publish</wp:status>
  <category domain="event_category" nicename="special">スペシャル</category>
  <content:encoded><![CDATA[...]]></content:encoded>
  <wp:postmeta>
    <wp:meta_key>event_date</wp:meta_key>
    <wp:meta_value>20260504</wp:meta_value>
  </wp:postmeta>
  <!-- 他のACFフィールド -->
</item>
```

### ⚠️ パースの限界

自動パースで埋まらない項目（手動対応）：
- 出演モデルのリレーション再結線（モデル名→CPT投稿ID）
- 料金の構造化（テキストそのまま入る）
- 画像の肖像権チェック

→ パース後、WP管理画面で各イベントを開いて目視チェック・補完する作業が発生。

## E-6. Phase 5: 画像移行

**期間目安**: 1〜2日

### 方針

**全画像を移行するのではない。** 肖像権・鮮度の観点から以下の方針：

1. **過去1年以内のイベントバナー** → 新サイトに移行
2. **それ以前のバナー** → 選別してアーカイブ保管（非公開）
3. **モデルのプロフィール写真** → 肖像権許諾が取れたもののみ移行
4. **古い/不要な画像** → 移行しない

### 実作業

1. `wp-content/uploads/` 配下から必要な画像をローカルで選別
2. ZIP化
3. 新WP管理画面のメディアライブラリへ一括アップロード
4. WXRインポート時に、`<img src="...">` を新URLに置換するスクリプトを挟む

### 画像最適化

- SWELLの画像遅延読み込み（lazy loading）を利用
- WebP自動変換プラグイン（`EWWW Image Optimizer` 等）の導入検討
- アップロード前に手動圧縮（TinyPNG等）

## E-7. Phase 6: 公開前最終確認

**期間目安**: 1〜2日

### チェックリスト

- [ ] 全ページでレイアウト崩れなし
- [ ] モバイル表示チェック（実機で確認）
- [ ] 全リンクが切れていない
- [ ] イベント一覧がカテゴリフィルタで正しく動作
- [ ] モデル一覧が表示される
- [ ] 検索機能
- [ ] お問い合わせフォーム動作確認（テスト送信）
- [ ] お申し込みフォーム動作確認
- [ ] Google Map埋め込み表示
- [ ] SSL証明書有効
- [ ] サイトマップXML生成確認
- [ ] robots.txt 設定確認
- [ ] OGP/Twitter Card 表示確認
- [ ] ファビコン設定
- [ ] 404ページカスタマイズ
- [ ] KARINTOW担当者のログインテスト
- [ ] 編集者権限で投稿追加テスト

## E-8. Phase 7: ドメイン切替（カットオーバー）

**期間目安**: 作業時間1時間（深夜実施推奨）

### 手順

1. **前日**: 旧DNS TTL を 300秒に短縮
2. **当日深夜**:
   - 新WPサイトで最終動作確認
   - ConoHa WING管理画面で `studio-g.net` をサイトに紐付け
   - DNSネームサーバーを ConoHa に変更（またはAレコード変更）
   - SSL証明書自動発行を待つ（数分〜数十分）
3. **切替後**:
   - `https://studio-g.net/` で新サイトが表示されるか確認
   - 旧URL（`/event/27397/`等）が継承されているか確認
   - `/one/XXX/` が `/event/XXX/` にリダイレクトされるか確認
   - お問い合わせフォームの送信先メールが正しいか確認
4. **翌日**:
   - Google Search Console で新サイトを再登録
   - サイトマップXML再送信

### ロールバック手順

万が一問題発生時は、DNSを旧サーバーに戻す（TTL 300秒なので5分で復元）。

## E-9. Phase 8: 旧環境停止

**期間目安**: 新サイト稼働後1〜2ヶ月の並行運用を経て

### 手順

1. 1ヶ月以上、問題がないことを確認
2. さくらVPS管理画面から解約手続き
3. 解約前に最終バックアップ取得（wgetミラーは既にあるが念のため）
4. GitHubリポジトリに「旧環境停止」マーカーコミット

## E-10. 作業工数見積

| Phase | 作業内容 | 工数（司令官） |
|---|---|---|
| 1 | 新環境準備 | 1日 |
| 2 | CPT/ACF構築 | 0.5日 |
| 3 | マスタデータ登録 | 1日 |
| 4 | イベント自動移行 | 2〜3日 |
| 5 | 画像移行 | 1〜2日 |
| 6 | 公開前確認 | 1〜2日 |
| 7 | ドメイン切替 | 0.5日（ただし深夜作業） |
| 8 | 旧環境停止 | 0.1日 |
| **合計** | | **約8〜10日** |

別途、設計ドキュメント整備・Canvaテンプレ・運用マニュアル作成の工数が加算される。

---

**未解決項目**: `00-questions.md` の Q02 (ブランドカラー) が決まらないと Phase 3 以降の
デザイン実装が進まない。最優先で確定する。
