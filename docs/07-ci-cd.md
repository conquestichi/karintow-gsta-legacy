# G. CI/CD・自動デプロイ

GitHub Actions による自動化の設定・運用ガイド。

## G-1. ワークフロー一覧

| ファイル | 目的 | 実行タイミング | Secrets依存 |
|---|---|---|---|
| `.github/workflows/docs-check.yml` | 設計docsの検証（ファイル存在・UTF-8・最小サイズ） | `docs/**` への push | 不要 |
| `.github/workflows/deploy-wp.yml` | SWELL子テーマを本番サーバーへ自動デプロイ | `wp/themes/karintow-child/**` への push | 必要 |

## G-2. docs-check（動作中）

Secrets 不要で push のたびに動く。失敗すれば GitHub 画面上で赤いバッジが出る。

### チェック内容

1. `docs/` 配下に必須ファイル（README, 00〜06）が全部存在するか
2. 各 md ファイルが 100 バイト以上あるか
3. UTF-8 として正当か

### 実行結果の確認

GitHub リポジトリ → `Actions` タブ → `docs-check` ワークフロー

## G-3. deploy-wp（待機中）

Secrets が未設定の間は skip ジョブが走るだけで、デプロイは実行されない。
ConoHa WING 契約後に以下の Secrets を設定することで自動的に有効化される。

### 必要な Secrets

| Secret名 | 内容 | 例 |
|---|---|---|
| `DEPLOY_HOST` | ConoHa WING の FTP/SFTP サーバー名 | `wing-web-XXX.conoha.jp` |
| `DEPLOY_USER` | FTPアカウント名 | `g1234567` |
| `DEPLOY_PASSWORD` | FTPパスワード | （ConoHa管理画面で確認） |
| `DEPLOY_PORT` | ポート番号（省略可、デフォルト 21） | `21` (FTP) / `990` (FTPS) / `22` (SFTP) |
| `DEPLOY_PROTOCOL` | プロトコル（省略可、デフォルト `ftps`） | `ftp` / `ftps` / `sftp` |
| `DEPLOY_SERVER_DIR` | サーバー側の子テーマ配置パス | `/home/USERNAME/public_html/studio-g.net/wp-content/themes/karintow-child/` |

### Secrets 設定手順

1. ConoHa WING 管理画面 → サイト管理 → FTP/SSH → FTPアカウント情報を取得
   - サーバー名、アカウント名、パスワードを控える
2. GitHub リポジトリ (`conquestichi/karintow-gsta-legacy`) を開く
3. `Settings` タブ → 左メニュー `Secrets and variables` → `Actions`
4. `New repository secret` をクリックして上記6個を1つずつ登録
5. 登録後、`wp/themes/karintow-child/` に何か変更を加えて push
6. `Actions` タブでワークフロー実行状況を確認
7. 成功すれば子テーマがサーバー側に反映される

### 初回設定時の注意

- **デプロイ先ディレクトリが存在するか確認**
  - `.../wp-content/themes/karintow-child/` がサーバー側に存在すること
  - 存在しない場合は手動で1回作成するか、ConoHa側で WordPress と SWELL 親テーマを先にインストールしておく
- **権限**: FTPユーザーが該当ディレクトリに書き込み可能であること
- **プロトコル選択**:
  - ConoHa WING ベーシックプランの標準は **FTPS (FTP over TLS)**
  - SFTP (SSH経由) を使う場合はConoHa側でSSHを有効化する必要あり
  - **推奨**: まず FTPS で試す（`DEPLOY_PROTOCOL=ftps`、`DEPLOY_PORT=990`）

### デプロイ対象

**含めるもの**:
- `wp/themes/karintow-child/style.css`
- `wp/themes/karintow-child/functions.php`
- `wp/themes/karintow-child/**/*.php`
- `wp/themes/karintow-child/assets/**`

**除外するもの**（`.github/workflows/deploy-wp.yml` の exclude 設定で自動除外）:
- `.git*` 関連
- `node_modules/`
- `README.md`
- `.DS_Store`

### ロールバック

デプロイに失敗した or 間違ったバージョンがアップされた場合：

1. **即座のロールバック**: ConoHa WING の自動バックアップ（14日分）から復元
2. **Gitベース**: 問題のないコミットに `git revert` → push → 自動再デプロイ

## G-4. セキュリティ

### 絶対にやらないこと

- ⚠️ `DEPLOY_PASSWORD` をコードやコメントに書かない
- ⚠️ Secrets 値を Slack/メール/チャットに貼らない
- ⚠️ `.env` や `wp-config.php` をリポジトリにコミットしない

### やるべきこと

- FTPユーザーは本番テーマ配置ディレクトリ**のみ**書き込み可に制限
- パスワードは定期的にローテーション（3ヶ月ごと推奨）
- 漏洩疑いがあれば即座にパスワード変更 + GitHub Secret 更新
- 2段階認証（2FA）を GitHub アカウントに有効化

## G-5. トラブルシューティング

### docs-check が失敗する

- 必須ファイルが削除されていないか確認
- UTF-8 ではないファイルが混入していないか確認
- ワークフローログを Actions タブで確認

### deploy-wp が失敗する（Secrets 設定済み）

| エラー | 原因 | 対処 |
|---|---|---|
| `Authentication failed` | パスワード間違い / アカウント無効 | ConoHa 管理画面で再確認 |
| `Connection timeout` | ホスト名間違い / FW | ホスト名再確認、ConoHaのIP制限確認 |
| `Directory not found` | `DEPLOY_SERVER_DIR` のパス誤り | 実パスを再確認 |
| `Permission denied` | FTPユーザーの書き込み権限なし | ConoHa管理画面でFTPユーザーの権限変更 |

### deploy-wp が常に skip される

- Secrets 3点（HOST/USER/PASSWORD）のいずれかが空文字列になっていないか確認
- リポジトリ Secrets（環境 Secrets ではない）に設定しているか確認

## G-6. 今後の拡張候補

- **P2**: PR プレビュー環境の自動構築（ConoHa ではなく Vercel等のプレビュー用）
- **P2**: Lighthouse CI によるパフォーマンス自動測定
- **P3**: テスト用ステージング環境への並行デプロイ
- **P3**: プラグイン自動更新の bot 化（Dependabot 風）

---

**ステータス**:
- ✅ docs-check 仕込み完了、push から即動作
- ⏸ deploy-wp 仕込み完了、Secrets 待ち（ConoHa契約後に有効化）
