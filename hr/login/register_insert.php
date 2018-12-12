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

    // データの引き継ぎ
    $name = $_SESSION['name'];
    $mail = $_SESSION['mail'];
    
    //パスワードのハッシュ化(サーバ上でのみ対応可)
    $password_hash =  password_hash($_SESSION['password'], PASSWORD_DEFAULT);

    //データベース接続
    $pdo = db_con();

    // データベースにすでにユーザーが存在しているか確認
    $sql = "SELECT * FROM user_table WHERE lid = :lid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':lid',$mail,PDO::PARAM_STR);
    $val = $stmt->execute();

    // SQLエラーの時
    if($val === false){
        queryError($stmt);
    } else {
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            if($res['mail'] == $mail){
                // データが重複していた場合はログインページに戻す
				echo '<script>alert("すでに登録されているアドレスです");location.href="../login.php";</script>';
                
                exit();
				// 以下の処理は飛ばす
                break;
            }
        }
    }

    // データベース登録
    $url = "../img/user.svg";
    $sql = "INSERT INTO user_table(lid,lpw,user_name,photourl,indate)VALUES(:lid,:lpw,:user_name,'img/user.svg',sysdate())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':lid',$mail,PDO::PARAM_STR);
    $stmt->bindValue(':lpw',$password_hash,PDO::PARAM_STR);
    $stmt->bindValue(':user_name',$name,PDO::PARAM_STR);
    $val = $stmt->execute();

    // DB切断
    $pdo = null;

    // SESSIONを破棄
    if (isset($_COOKIE["PHPSESSID"])) {
        setcookie("PHPSESSID", '', time() - 1800, '/');
    }
    session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会員登録完了画面</title>
</head>
<body>
 
<?php if (count($errors) === 0): ?>
<h1>会員登録完了画面</h1>
 
<p>登録完了いたしました。</p>
<p><a href="../login.php">ログイン画面</a></p>
 
<?php elseif(count($errors) > 0): ?>
 
<?php
foreach($errors as $value){
	echo "<p>".$value."</p>";
}
?>
 
<?php endif; ?>
 
</body>
</html>