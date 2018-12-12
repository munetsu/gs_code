<?php
    session_start();

    // funcs読み込み
    include('../funcs/funcs.php');

    // SESSION確認
    chkSsid();

    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');

    //エラーメッセージの初期化
    $errors = array();
 
    if(empty($_POST)) {
        header("Location: register.php");
        exit();
    }else{
        // POST情報の取得
        $name = h($_POST['name']);
        $mail = h($_POST['mail']);
        $password = h($_POST['password']);

        //前後にある半角全角スペースを削除
        $name = spaceTrim($name);
        $mail = spaceTrim($mail);
        $password = spaceTrim($password);

        // パスワードの非表示化
        $password_hide = str_repeat('*', strlen($password));
    }

    //エラーが無ければセッションに登録
    if(count($errors) === 0){
        $_SESSION['name'] = $name;
        $_SESSION['mail'] = $mail;
        $_SESSION['password'] = $password;
    }
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会員登録確認画面</title>
</head>
<body>
<h1>会員登録確認画面</h1>
 
<?php if (count($errors) === 0): ?>
 
 
<form action="register_insert.php" method="post">
 
<p>ユーザー名<?php echo $_SESSION['name'];?></p>
<p>メールアドレス：<?php echo $_SESSION['mail'];?></p>
<p>パスワード：<?php echo $password_hide;?></p>
 
<input type="button" value="戻る" onClick="history.back()">
<input type="submit" value="登録する">
 
</form>
 
<?php elseif(count($errors) > 0): ?>
 
<?php
foreach($errors as $value){
	echo "<p>".$value."</p>";
}
?>
 
<input type="button" value="戻る" onClick="history.back()">
 
<?php endif; ?>
 
</body>
</html>