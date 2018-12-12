<?php
    session_start();

    // 関数読み込み
    include('funcs/funcs.php');
    chkSsid();

    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');

    // ログインユーザーのID・名前取得
    $id = $_SESSION['id'];

    // POSTデータの取得
    $task_id = $_POST['task_id'];
    $star = $_POST['star'];

    // DB接続
    $pdo = db_con();
    $sql = "UPDATE task_table SET preview=$star WHERE task_id = $task_id";
    $stmt = $pdo->prepare($sql);
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
    
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/task_update.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
</body>
</html>