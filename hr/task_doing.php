<?php   
    session_start();

    // 関数読み込み
    include('funcs/funcs.php');
    chkSsid();

    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');

    // ログインユーザーのID・名前取得
    $id = $_SESSION['id'];

    // POSTデータ取得
    $task_id = $_POST['task_id'];

    // DB接続
    $pdo = db_con();
    $sql = "UPDATE task_table SET status=1 WHERE task_id = $task_id";
    $stmt = $pdo->prepare($sql);
    $val = $stmt->execute();

    if($val === false){
        queryError($stmt);
    }

    echo '着手中';

    exit;

?>