# 日経平均225銘柄を自動取得してTシャツのデザインにする

## 要件

### 株式データ取得

1. 日経平均225銘柄の銘柄コードを取得
2. 当日の225銘柄の各前日比（プラス、マイナス、変わらず）を取得

### PDF出力

1. ベースとなるPDFに先の銘柄コードと色（黒、白抜き）を配置
2. pdf出力（aiファイル）

### Tシャツ販売サイトにアップロード

1. chronium+seleniumで自動でアップロードする。
   - 販売サイトは多ければ多いほどよい

#### 上記を毎日15時以降に実行する。
