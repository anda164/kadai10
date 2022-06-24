<?php 
    session_start();
    if($_SESSION){
        echo "<p>${_SESSION['login']}さん、こんにちは。（ログイン済）</p>";
        $link = "<p><a href='./item_read.php'>一覧を参照する</a></p>";
        $link .= "<a href='./logout.php'>ログアウト</a>";
    }else{
        $link= "ログインしてください。<br>
                <form action='login.php' method='post'>
                    Usr: <input type='text' name='usr'>
                    Pwd: <input type='text' name='pwd' id=''>
                    <input type='submit'>
                </form>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!--
    <form action="login.php" method="post">
        Usr: <input type="text" name="usr">
        Pwd: <input type="text" name="pwd" id="">
        <input type="submit">
    </form>
    -->
    <?= $link ?>
    

</body>
</html>