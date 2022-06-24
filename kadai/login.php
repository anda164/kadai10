<?php
    ini_set('display_errors', 1);
    //session_start();
    /*
    if (!isset($_SESSION["login"])) {
        echo "dbg";
        header("Location: index.php");
        exit();
    }*/

    var_dump($_POST);
    if (!isset($_POST["usr"] )|| $_POST["usr"] ==""){
        header("Location: index.php");
        
        exit("ErrorParam: usr");

    }

    if (!isset($_POST["pwd"] )|| $_POST["pwd"] ==""){
        exit("ErrorParam: pass");
    }

    require_once("./common/db_connect.php");
    require_once("./common/fn_common.php");

    session();

    $pdo = get_pdo("root","root");

    $tbl = "user";

    //get param
    $usr = $_POST["usr"];


    // 1. SQL文を用意

    $sql = "SELECT * FROM ${tbl} WHERE name = :usr;";
    $stmt = $pdo->prepare($sql);

    // 「:id」に対して引数のキー値をセット
    $stmt->bindValue(':usr', $_POST["usr"]);
    
    // SQL実行
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($result){
        if(password_verify($_POST['pwd'], $result['pass'])){
            echo "ログイン認証に成功しました";
            
            session_regenerate_id(TRUE); //セッションidを再発行
            $_SESSION["login"] = $_POST['usr']; //セッションにログイン情報を登録
            echo "<br>";
            echo "session ---<br>";

            var_dump($_SESSION["login"] );
            header("Location: item_read.php"); //ログイン後のページにリダイレクト
            echo "<br>";
            echo "session ---<br>";

            exit();
        }else{
            echo "password error";
            header("Location: index.php"); //ログインページにリダイレクト
        }
    }else{
        $sql = "INSERT INTO ${tbl} (name, pass) VALUES(:usr, :pwd)";
        $stmt = $pdo->prepare($sql);

        //$stmt->execute(array(':usr' => $_POST['usr'],':pwd' => password_hash($_POST['pwd'], PASSWORD_DEFAULT)));

        $stmt->bindValue(':usr', $_POST["usr"] , PDO::PARAM_STR);  //自動採番済
        $stmt->bindValue(':pwd', password_hash($_POST['pwd'], PDO::PARAM_STR));

        $status = $stmt->execute();
        echo "ユーザーを登録しました";

    }



?>