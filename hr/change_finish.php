<?php 
    session_start();

    // 関数読み込み
    include('funcs/funcs.php');
    chkSsid();

    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');

    // ログインユーザーのID取得
    $id = $_SESSION['id'];

    // DB接続
    $pdo = db_con();
    $sql = "SELECT task_id,name,deadline,deadtime,important,detail,url,status,user_table.user_name,user_table.id FROM task_table INNER JOIN user_table ON task_table.recipient_id = user_table.id WHERE task_table.client_id = $id AND task_table.status = 2";
    $stmt = $pdo->prepare($sql);
    $val = $stmt->execute();

    $view = '';
    $tasklevel = ["","緊急かつ重要","緊急ではないが重要","緊急だが重要ではない","緊急かつ重要ではない"];

    $count = 0;
    if($val === false){
        queryError($stmt);
    } else {
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
            // var_dump($result);
            // exit;
            if($count == 0){
                $view .= '<div class="listline">';
                $view .= '<div class="listall">';
                $view .= '<div class="oneblock"><p>Todo名</p><span>'.$result['name'].'</span></div>';
                $view .= '<div class="oneblock"><p>重要度</p><span>'.$tasklevel[$result['important']].'</span></div>';
                $view .= '<div class="oneblock"><p>納期</p><span>'.$result['deadline'].$result['deadtime'].'</span></div>';
                $view .= '<div class="oneblock"><p>だれに</p><span>'.$result['user_name'].'</span></div>';
                $view .= '<div class="oneblock"><p>詳細</p><span>'.$result['detail'].'</span></div>';
                $view .= '<div class="oneblock"><p>添付ファイル</p><span>'.$result['url'].'</span><button id="btn">ファイルダウンロード</button></div>';
                $view .= '<form action="change_chat.php" method="post" name="doing'.$count.$id.'"><input type="hidden" name="task_id" value="'.$result['task_id'].'"></form>';
                $view .= '<div class="oneblock"><a href="#" class="chat" id="doing'.$count.$id.'" data-value="'.$result['task_id'].'">確認／メッセージを送る</a></div>';
                $view .= '</div>';
            } else if($count % 3 == 0){
                $view .= '</div>';
                $view .= '<div class="listline">';
                $view .= '<div class="listall">';
                $view .= '<div class="oneblock"><p>Todo名</p><span>'.$result['name'].'</span></div>';
                $view .= '<div class="oneblock"><p>重要度</p><span>'.$tasklevel[$result['important']].'</span></div>';
                $view .= '<div class="oneblock"><p>納期</p><span>'.$result['deadline'].$result['deadtime'].'</span></div>';
                $view .= '<div class="oneblock"><p>だれに</p><span>'.$result['user_name'].'</span></div>';
                $view .= '<div class="oneblock"><p>詳細</p><span>'.$result['detail'].'</span></div>';
                $view .= '<form action="change_chat.php" method="post" name="doing'.$count.$id.'"><input type="hidden" name="task_id" value="'.$result['task_id'].'"></form>';
                $view .= '<div class="oneblock"><a href="#" class="chat" id="doing'.$count.$id.'" data-value="'.$result['task_id'].'">確認／メッセージを送る</a></div>';
                $view .= '</div>';
            } else {
                $view .= '<div class="listall">';
                $view .= '<div class="oneblock"><p>Todo名</p><span>'.$result['name'].'</span></div>';
                $view .= '<div class="oneblock"><p>重要度</p><span>'.$tasklevel[$result['important']].'</span></div>';
                $view .= '<div class="oneblock"><p>納期</p><span>'.$result['deadline'].$result['deadtime'].'</span></div>';
                $view .= '<div class="oneblock"><p>だれに</p><span>'.$result['user_name'].'</span></div>';
                $view .= '<div class="oneblock"><p>詳細</p><span>'.$result['detail'].'</span></div>';
                $view .= '<form action="change_chat.php" method="post" name="doing'.$count.$id.'"><input type="hidden" name="task_id" value="'.$result['task_id'].'"></form>';
                $view .= '<div class="oneblock"><a href="#" class="chat" id="doing'.$count.$id.'" data-value="'.$result['task_id'].'">確認／メッセージを送る</a></div>';
                $view .= '</div>';
            }
            $count += 1;
        }
        if($count %3 !=0){
            $view .= '</div>';
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>トップページ</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/top.css">
</head>
<body>
    <!-- ヘッダー -->
    <div class="header">
        <!-- ロゴ -->
        <div class="logoarea">
            <img src="img/logo.png" alt="" id="logo">
        </div>
        <!-- 役割部分 -->
        <div class="side">
            <div>
                <ul class="sidelist">
                    <li class=list><a href="">依頼リスト</a></li>
                    <li class="list hide"><a href="top.php" id="sidechange">受託リスト</a></li>
                    <li class="list hide"><a href="logout.php">ログアウト</a></li>
                </ul>
            </div>
            <div class="triangle">
                <img src="img/side.svg" alt="" class="sideicon">
            </div>
        </div>
    </div>
    <div class="mainarea">
        <div class="leftarea">
        <!-- ナビ -->
        <div class="menu">
            <ul>
                <li><a href="top.php" class="menu_a"><img src="img/allicon.svg" class="menuicon" id="menuicon1"><span class="hovertext">全体</span></a></li>
                <li><a href="#" class="menu_a"><img src="img/notdoing.svg" class="menuicon" id="menuicon2"><span class="hovertext">未着手</span></a></li>
                <li><a href="#" class="menu_a"><img src="img/doing.svg" class="menuicon" id="menuicon3"><span class="hovertext">着手中</span></a></li>
                <li><a href="change_finish.php" class="menu_a"><img src="img/finish.svg" class="menuicon" id="menuicon4"><span class="hovertext">完了</span></a></li>
                <li><a href="setting.php" class="menu_a"><img src="img/setting.svg" class="menuicon" id="menuicon5"><span class="hovertext">設定</span></a></li>
            </ul>
        </div>
        </div>

        <div class="rightarea">
            <!-- メイン -->
            <div class="main">
            <?php echo $view?>
        
            <!-- フッター -->
            <div class="footer">
                copyright
            </div>
        </div>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    
    <script>
        // PHP変数を引き継ぎ
        let user_id = <?php echo $id; ?>;
    </script>
    <script src="js/top.js"></script>
    <script src="js/change_finish.js"></script>
</body>
</html>