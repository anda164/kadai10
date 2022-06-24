<?php
    //session_start();
    require_once("./common/fn_common.php");
    //session();
    
    if (!isset($_SESSION["login"])) {
        
        //header("Location: index.php");
        //exit();
        $message = "<a href='./login.php'>ログイン</a>";
    }else{
        //ログインされている場合は表示用メッセージを編集
        $message = $_SESSION['login']."さんのカート";
        $message = htmlspecialchars($message);
        $message .= "<br><a href='logout.php'>ログアウト</a>";
    }

    echo $message;

      
    //検索パラメータ取得
    $item_id = $_GET["item_id"];
    $srch_name = $_GET["name"];
    $srch_desc = $_GET["desc"];
    $srch_date_fr = $_GET["date_from"]; //対象データ(自)
    $srch_date_to = $_GET["date_to"]; //対象データ(至)　※データ作成日ベース
?>

<h1>カート内一覧</h1>
<!--
<form action="./item_read.php" method="get">
    <table>
        <tr><th>ID:</th><td><input id="id" name="id" value="<?= $srch_id ?>"></td></tr>
        <tr><th>Name</th><td><input id="name" name="name" value="<?= $srch_name ?>"></td></tr>
        <tr><th>Description</th><td><input id="desc" name="desc" value="<?= $srch_desc ?>"></td></tr>
        <tr><th>Date</th><td><input id="date_from" type="date" name="date_from" value="<?= $srch_date_fr ?>"> - <input id="date_to" type="date" name="date_to" value="<?= $srch_date_to ?>"></td></tr>    
    </table>
    <input type="submit" value="Search" id="search_btn">
</form>
-->

<?php
//-----------------
//データ表示部生成処理

//=====
//DB読み込み処理

// ０. DB 接続
require_once "./common/db_connect.php"; // DB接続関数読み込み(DB名:"kadai_db", 文字コード:"utf8"; ホスト名:localhost)
$pdo = get_pdo("root","root"); // DB接続関数呼び出し(#1[DB User]: "root", #2[DB Pass]: "root"

// 1. SQL文を用意

$ref = new DateTime($_GET["date_to"]);
$srch_date_to = $ref->modify('+1 day')->format('Y-m-d H:i:s'); //当日日付を含めるため検索値をインクリメント

$sql = "SELECT * FROM cart";
$sql .= " WHERE user = :user";
$sql .= " AND item = :item;";
$stmt = $pdo->prepare($sql);

// 2. 条件Bind
$stmt->bindValue(':user', $_SESSION['login'] , PDO::PARAM_STR);  //自動採番済
$stmt->bindValue(':item', $item_id , PDO::PARAM_STR);  //自動採番済
$status = $stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$num = 1;
if($result){
    $num += $result["num"];
    $sql = "UPDATE cart set num = :num WHERE item=:item AND user=:user;";
}else{
    $sql = "INSERT INTO cart(id, user, item, num) VALUES (NULL, :user, :item, :num);";
}

$stmt = $pdo->prepare($sql);

// 2. 条件Bind
$stmt->bindValue(':user', $_SESSION['login'] , PDO::PARAM_STR);  //自動採番済
$stmt->bindValue(':item', $item_id , PDO::PARAM_STR);  //自動採番済
$stmt->bindValue(':num', $num , PDO::PARAM_INT);  //自動採番済

$status = $stmt->execute();

//３．データ表示
require_once "./common/fn_common.php"; //XSS対策関数を含む共通関数群読み込み


$sql = "SELECT * FROM items INNER JOIN cart ON items.id = cart.item WHERE user= :user";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user', $_SESSION['login'] , PDO::PARAM_STR);  //自動採番済
$status = $stmt->execute();

if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  $view .= "<table>";
  $view .= "<th>Item ID</th>";
  $view .= "<th>Item Name</th>";
  $view .= "<th>Description</th>";
  $view .= "<th>Image</th>";
  $view .= "<th>Num</th>";
  $view .= "<th>+</th>";
  $view .= "<th>-</th>";
  
  
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    var_dump($result);
    echo ("<br>");
    
    //select.php の $view処理部分にXSS対策をする。
    $id     = h($result["id"]);
    $name   = h($result["name"]);
    $desc   = h($result["description"]);
    $impth  = h($result["image_path"]);
    $num  = h($result["num"]);

    $view .= "
            <tr>
                <td><a href='item_add.php?id=${id}'>${id}</a></td>
                <td>${name}</td><td>${desc}</td>
                <td><img src='${impth}' alt='${impth}'></td>
                <td>${num}</td>
                <td><a href='remove_cart.php?id=${item_id}'>+1</a>
                <td><a href='remove_cart.php?id=${item_id}'>-1</a>
            </tr>
            
            ";
  }
  $view .= "</table>";


}



if($resultNum>0){
    //商品存在確認
    $sql = "SELECT * FROM cart";
    $sql .= " WHERE user = :user";
    $sql .= " AND item = :item;";
    $stmt = $pdo->prepare($sql);

    // 2. 条件Bind
    $stmt->bindValue(':user', $_SESSION['login'] , PDO::PARAM_STR);  //自動採番済
    $stmt->bindValue(':item', $item_id , PDO::PARAM_STR);  //自動採番済
    $status = $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $num = $result["num"] + 1;

    var_dump($result);
    echo($sql);
    echo($result["user"]."<br>");
    echo($result["item"]."<br>");
    echo($result["num"]."<br>");
    




    echo "あるよ";
}else{
    echo "空です";
}



?>
<!-- Main[Start] -->
<div>
    <div class="container jumbotron">
        <?= $view ?>
    </div>
</div>
<!-- Main[End] -->


<ul>
    <li><a href="item_read.php">確認する</a></li>
    <li><a href="index.php">戻る</a></li>
</ul>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    //フォーム検索パラメータ 日付エラーチェック
    $("#search_btn").on("click", function(){
        const $in_date_fr = $("#date_from").val();
        const $in_date_to = $("#date_to").val();

        if ($in_date_to != "" && $in_date_fr > $in_date_to) {
            alert("検索範囲の指定が不正です");
        }
    });

</script>