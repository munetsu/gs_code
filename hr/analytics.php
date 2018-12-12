<?php
    session_start();

    // 関数読み込み
    include('funcs/funcs.php');
    chkSsid();

    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');

    // ログインユーザーのID取得
    $id = $_SESSION['id'];

    // POSTデータの受け取り
    $datestart = $_POST['datestart'];
    $dateend = $_POST['dateend'];

    // DB接続
    $pdo = db_con();

    // 依頼者ごとのタスク完了数と評価を集計
    $sql = "SELECT client_id,COUNT(*),AVG(preview) FROM task_table WHERE recipient_id = $id AND status=2 AND (create_date >= '$datestart' AND create_date <= '$dateend') GROUP BY client_id";
    $stmt = $pdo->prepare($sql);
    $val = $stmt->execute();
    
    
    $count=0;
    $client_id = [];
    $amount = [];
    $preview =[];
    if($val === false){
        queryError($stmt);
    } else {
        header('Content-type: application/json');
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        // foreach($result as $loop){
        //     $graph[] = $loop;
        // }
        // $graph = json_encode($graph);
    }

    // echo ($result);


         















    // 不要コード
    // $sql = "SELECT * FROM task_table INNER JOIN user_table ON task_table.client_id = user_table.id WHERE task_table.recipient_id = $id AND status=2 AND (create_date >= '$datestart' AND create_date <= '$dateend')";
    // $stmt = $pdo->prepare($sql);
    // $val = $stmt->execute();

    // $graphdata = [];
    // $user_data = [];
    // $date_data = [];
    // $preview_data = [];
    // if($val === false){
    //     queryError($stmt);
    // } else {
    //     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     foreach($result as $loop){
    //         $graphdata[] = array(
    //             'user_name'=>$loop['user_name'],
    //             'preview'=>$loop['preview']
    //         );
    //         $user_data[] = $loop['user_name'];
    //         $date_data[] = $loop['create_date'];
    //         $preview_data[] = $loop['preview'];
    //     }
    //     var_dump($graphdata);
    //     var_dump($user_data);
    //     var_dump($date_data);
    //     var_dump($preview_data);
    // }

?>