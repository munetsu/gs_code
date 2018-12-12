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
    $important = $_POST['important'];
    // $important = 1;

    // DB接続
    $pdo = db_con();
    $sql = "SELECT task_id,name,deadline,deadtime,important,detail,status,user_table.user_name,user_table.id FROM task_table INNER JOIN user_table ON task_table.recipient_id = user_table.id WHERE task_table.client_id = $id AND task_table.important = $important";
    $stmt = $pdo->prepare($sql);
    // $stmt->bindValue(':important',$important,PDO::PARAM_INT);
    $val = $stmt->execute();

    $view = '';
    $tasklevel = ["","緊急ではないが重要","緊急かつ重要","緊急だが重要ではない","緊急かつ重要ではない"];

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
                $view .= '<form action="change_chat.php" method="post" name="doing'.$count.$id.'"><input type="hidden" name="task_id" value="'.$result['task_id'].'"></form>';
                $view .= '<div class="oneblock"><a href="#" class="check" id="doing'.$count.'" data-value="'.$result['task_id'].'">確認する</a><a href="#" class="chat" id="doing'.$count.$id.'" data-value="'.$result['task_id'].'">メッセージを送る</a></div>';
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
                $view .= '<form action="change_chat" method="post" name="doing'.$count.$id.'"><input type="hidden" name="task_id" value="'.$result['task_id'].'"></form>';
                $view .= '<div class="oneblock"><a href="#" class="check" id="doing'.$count.'" data-value="'.$result['task_id'].'">確認する</a><a href="#" class="chat" id="doing'.$count.$id.'" data-value="'.$result['task_id'].'">メッセージを送る</a></div>';
                $view .= '</div>';
            } else {
                $view .= '<div class="listall">';
                $view .= '<div class="oneblock"><p>Todo名</p><span>'.$result['name'].'</span></div>';
                $view .= '<div class="oneblock"><p>重要度</p><span>'.$tasklevel[$result['important']].'</span></div>';
                $view .= '<div class="oneblock"><p>納期</p><span>'.$result['deadline'].$result['deadtime'].'</span></div>';
                $view .= '<div class="oneblock"><p>だれに</p><span>'.$result['user_name'].'</span></div>';
                $view .= '<div class="oneblock"><p>詳細</p><span>'.$result['detail'].'</span></div>';
                $view .= '<form action="change_chat" method="post" name="doing'.$count.$id.'"><input type="hidden" name="task_id" value="'.$result['task_id'].'"></form>';
                $view .= '<div class="oneblock"><a href="#" class="check" id="doing'.$count.'" data-value="'.$result['task_id'].'">確認する</a><a href="#" class="chat" id="doing'.$count.$id.'" data-value="'.$result['task_id'].'">メッセージを送る</a></div>';
                $view .= '</div>';
            }
            $count += 1;
        }
        if($count %3 !=0){
            $view .= '</div>';
        }
        echo $view;
    }
?>
