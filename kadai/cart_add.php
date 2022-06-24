<?php
    //session_start();
    require_once("./common/fn_common.php");
    //session();
    
    if (!isset($_SESSION["login"])) {
        //$message = "<a href='./login.php'>ログイン</a>";
        header('Location: ./index.php');

    }else{
        //ログインされている場合は表示用メッセージを編集
        $message = $_SESSION['login']."さんのカート";
        $message = htmlspecialchars($message);
        $message .= "<br><a href='logout.php'>ログアウト</a>";
    }

//-----------------
//データ表示部生成処理

//=====
//DB読み込み処理

// ０. DB 接続
require_once "./common/db_connect.php"; // DB接続関数読み込み(DB名:"kadai_db", 文字コード:"utf8"; ホスト名:localhost)
$pdo = get_pdo("root","root"); // DB接続関数呼び出し(#1[DB User]: "root", #2[DB Pass]: "root"

// 1. SQL文を用意

$item_id = $_GET["item_id"];

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

//echo ("debug!");
header('Location: ./cart_show.php');

?>
