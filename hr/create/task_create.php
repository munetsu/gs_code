<?php
    session_start();
    // 関数読み込み
    include('../funcs/funcs.php');
    chkSsid();

    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');

    // ログインユーザーのID取得
    $id = $_SESSION['id'];

    // 入力フォームのデータ登録処理
    $title = h($_POST['title']);
    $important = $_POST['important'];
    $deadline = h($_POST['deadline']);
    $deadtime = h($_POST['deadtime']).'00';
    $name = h($_POST['recipient']);
    $rec_no = h($_POST['rec_no']);
    $detail = h($_POST['detail']);

    // var_dump($title.$deadline.$deadtime.$name.$rec_no.$detail);
    // exit;

    // DB接続
    $pdo = db_con();
    $sql = "INSERT INTO task_table(client_id,recipient_id,name,	important,deadline,deadtime,detail,create_date)VALUES(:client_id,:recipient_id,:name,$important,:deadline,:deadtime,:detail,sysdate())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':client_id',$id,PDO::PARAM_INT);
    $stmt->bindValue(':recipient_id',$rec_no,PDO::PARAM_INT);
    $stmt->bindValue(':name',$title,PDO::PARAM_STR);
    $stmt->bindValue(':deadline',$deadline);
    $stmt->bindValue(':deadtime',$deadtime);
    $stmt->bindValue(':detail',$detail,PDO::PARAM_STR);
    $val = $stmt->execute();

    if($val === false){
        queryError($stmt);
    }

    // DB切断
    $pdo = null;
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div></div>
    
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/create_finish.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
</body>
</html>