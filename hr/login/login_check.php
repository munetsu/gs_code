<?php
    session_start();
    // 関数読み込み
    include('../funcs/funcs.php');
    chkSsid();

    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');

    // POSTデータの受け取り
    $lid = h($_POST['lid']);
    $lpw = h($_POST['lpw']);

    // データが空だった場合
    if(empty($_POST)) {
        header("Location: ../login.php");
        exit();
    } else {

        // DB接続
        $pdo = db_con();

        // ログインチェック
        $sql ="SELECT * FROM user_table";
        $stmt = $pdo->prepare($sql);
        $val = $stmt->execute();

        if($val ===false){
            queryError($stmt);
        } else {
            while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
                if($res['lid'] == $lid){
                    if(password_verify($lpw,$res['lpw'])){
                        $_SESSION['id'] = $res['id'];
                        header('Location: ../top.php');
                        exit();
                        break;
                    }
                }
            }
            echo '<script>alert("ログインエラー");location.href="../login.php";</script>';
            exit();
        }
    }

    // DB切断
    $pdo = null;
?>