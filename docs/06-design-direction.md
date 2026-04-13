# F. デザイン方針

新サイトのビジュアルデザイン方向性を定義します。

## F-1. コンセプト

**"Fresh cuteness always nearby"** 的な明るくキレイかわいい世界観を、
Gスタ撮影会のオリジナリティで表現する。

モデルさんを主役として引き立たせる、写真が映える白ベースのクリーンな背景に、
柔らかな装飾要素と赤のブランドアクセントを配する。

### ターゲットユーザー（変更なし）

中年男性の写真愛好家層。ただし「おじさん向けの地味なサイト」ではなく、
「モデルさんを可愛く魅せる場」として設計する。
可読性（フォントサイズ・コントラスト・タップ領域）は確保する。

## F-2. カラーパレット

### プライマリ

| 用途 | カラー | 説明 |
|---|---|---|
| 背景メイン | `#ffffff` | 純白 |
| 背景サブ | `#fafafa` | セクション切替時の微差 |
| ブランド赤 | **`#d4002a`** | ボタン、見出しアクセント、ホバー |
| ブランド赤（濃） | `#a30020` | ホバー・プレス時の暗転 |
| ブランド赤（淡） | `#fde8ec` | バッジ背景、タグ背景 |

### テキスト

| 用途 | カラー |
|---|---|
| 見出し | `#1a1a1a` |
| 本文 | `#333333` |
| メタ情報 | `#888888` |
| リンク | `#d4002a` |

### ボーダー・区切り

| 用途 | カラー |
|---|---|
| 通常 | `#e5e5e5` |
| 薄め | `#f0f0f0` |

## F-3. タイポグラフィ

### フォントファミリ

- **見出し（日本語）**: Zen Kaku Gothic New (Google Fonts)
- **本文（日本語）**: Zen Kaku Gothic New
- **英字飾り**: Outfit (Google Fonts) — セクションタイトルの英語ラベル用
- **フォールバック**: 'Hiragino Sans', 'Noto Sans JP', sans-serif

### サイズ階層（中年男性配慮 + デザイン性の両立）

| 要素 | PC | SP |
|---|---|---|
| Hero catchcopy | 48px | 32px |
| Section heading (JP) | 32px | 24px |
| Section heading (EN flair) | 16px | 14px |
| Card title | 20px | 18px |
| Body | 17px | 16px |
| Meta | 14px | 13px |
| Button | 17px | 16px |

### 行間・文字組

- 本文 line-height: 1.8
- 見出し line-height: 1.4
- 和欧混植の letter-spacing: 0.03em

## F-4. 装飾要素（SVGオブジェクト）

フレッシュ撮影会に倣い、背景にSVG装飾を散布する。

### 種類（制作予定）

1. **葉っぱ / ボタニカル系**: 柔らかい曲線
2. **星 / キラキラ**: 4点星、まる
3. **波 / うねり**: 有機的な曲線
4. **ドット / しずく**: 小さなアクセント

### 制作方法

- **Canva** でSVG書き出し（シンプル図形なら十分）
- または Figma でオリジナル制作 → SWELLの子テーマ `/assets/svg/` に配置
- 色: 淡い赤 `#fde8ec` または薄グレー `#f5f5f5`、アルファ0.5〜0.8

### 配置ルール

- セクション間の余白に散らす（主役を邪魔しない程度）
- レスポンシブで数を減らす（モバイルは装飾最小）
- `position: absolute` + `z-index: -1` で最背面
- スクロールに応じた `parallax` 微効果（任意）

## F-5. レイアウトパターン

### ヒーローエリア（TOP）

```
┌───────────────────────────────────────────┐
│  [SVG装飾・左上]                          │
│                                           │
│       Fresh cuteness                      │
│       always nearby                       │
│       フレッシュな笑顔に、会いに行く。    │
│                                           │
│       [バナースライダー 横長]             │
│       [← →]                              │
│                                           │
│                          [SVG装飾・右下]  │
└───────────────────────────────────────────┘
```

### セクション見出しパターン

```
Event Schedule                    ← Outfit英字、小さめ、赤
## 今月のイベント                 ← 日本語大見出し、太字、黒
─────────────                    ← 赤の短い下線

[コンテンツ]
```

### カード（イベント・モデル）

- 白背景 + 薄いシャドウ `0 2px 12px rgba(0,0,0,.05)`
- 角丸: `border-radius: 16px`（現代的・柔らか）
- ホバー: `translateY(-4px)` + シャドウ強化
- モデルサムネ: **円形 `border-radius: 50%`**（旧サイト継承）
- 日付チップ: 赤背景 `#d4002a` + 白文字（旧サイト継承、色反転）

### ボタン

- プライマリ: 赤背景 `#d4002a` + 白文字
- セカンダリ: 白背景 + 赤文字 + 赤ボーダー
- パディング: `16px 32px`
- 角丸: `border-radius: 999px`（pill shape、ポップさの源）
- ホバー: 濃赤 `#a30020` + 軽い上方移動

## F-6. 参考サイトと引用範囲

| サイト | 引用要素 |
|---|---|
| **フレッシュ撮影会** | 全体トーン、SVG装飾、セクション構成、カレンダー縦スクロール方式、英日見出しペア |
| **TIF2025** | （参考度DOWN）フルワイドバナーの扱いのみ参考 |
| **旧Gスタ (karintowテーマ)** | 円形サムネイル、丸型日付チップ、Zen Kaku Gothic系フォント選定理念（丸み） |
| Simply Wall St | （参考度DOWN）ダーク時のカード質感は不採用、白基調に切替 |

## F-7. NG方針（やらないこと）

- **ダーク背景全体**: トーンと合わない（Phase 1ブレインストーム時の仮説）
- **ネオン筆記体フォント**（ジョイポリナイト系）: ターゲット層に不適
- **絵文字によるカテゴリアイコン**: 幼稚になりがち → SVG自作アイコンで対応
- **グラスモーフィズム**: 白ベースでは効果が弱い
- **過度なパーティクル・ボケ玉**: 写真の主役を邪魔する

## F-8. SWELLでの実装方針

### カスタマイザー設定

1. **外観 → カスタマイズ → サイト全体設定**
   - 基本カラー: `#d4002a`（赤）
   - テキストカラー: `#333333`
   - サイト背景: `#ffffff`
2. **外観 → カスタマイズ → 基本デザイン**
   - 角丸: やや大きめ（16px相当）
   - ボタン: ピル形状（50px）
3. **フォント設定**
   - Google Fonts で Zen Kaku Gothic New + Outfit をロード

### 子テーマで追加実装

- `/assets/svg/` 配下にSVG装飾素材配置
- `functions.php` でフッターに装飾SVG挿入
- `style.css` で追加スタイル（英日ペア見出し、pill button、card hover等）
- `archive-event.php`, `single-event.php`, `taxonomy-event_category.php` などのテンプレート自作

### 子テーマCSS（最低限の追加例）

```css
/* セクション英字飾り */
.section-label-en {
  font-family: 'Outfit', sans-serif;
  font-size: 16px;
  color: #d4002a;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  margin-bottom: 8px;
}

/* SVG装飾配置ベース */
.decor-svg {
  position: absolute;
  z-index: -1;
  opacity: 0.6;
  pointer-events: none;
}

/* 円形モデルサムネ */
.model-thumb-round {
  border-radius: 50%;
  aspect-ratio: 1 / 1;
  overflow: hidden;
}

/* 日付チップ（赤） */
.date-chip {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  background: #d4002a;
  color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
```

---

**未解決項目**:
- Q02 **ANSWERED**: 赤 `#d4002a`、白ベースメイン
- Q15 **PROPOSED**: カレンダーはフレッシュ方式（ACFだけで月縦スクロール実装、プラグイン不要）
