# 課題10 汎用情報登録機能DB版(買い物カゴ機能追加)
## ①課題内容（PHP4）
- 前回作成の商品等各種情報登録・参照の機能（ログイン認証付）に、買い物カゴ機能を追加
- 画面遷移：
-- index.php →(認証：login.php)→item_read.php（一覧表示）　→　cart_add.php（追加処理） →　cart_show.php（カート内表示処理）
    cart_read.php からの追加の際、数量１で追加、cart_show.phpに自動遷移
    cart_show.php 内、各商品行の ＋/- をクリックすることにより、登録数を増減可能（0になると行自体を削除）
    cart_show.php 内、「カートを空にする」で当該カート内のデータを全件削除（セッションユーザー）
## ②工夫した点・こだわった点
- カゴはセッションユーザー単位で保持するものとし他のユーザーのデータが削除できないよう制限
- カゴ内の数量増減機能は少し苦戦した

## ③質問・疑問
- カゴ内の増減はいちいちDBサーバーに照会せずJavascriptで増減し、結果だけを更新する形にした方が良さそう
- だが、都度DBに書き込んでいるため、編集途中で落ちた場合でも特に処理を行わなくてもカート内の情報は確実に保持していてくれるので、こちらの処理の方が実装しやすい面もある
- ｌｏｃａｌhostでの環境なのでど処理速度にも特に影響ないということかもしれないので、実環境での動作次第で選択ということと理解した

# kadai10

