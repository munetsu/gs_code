<?php
    session_start();
    // 関数読み込み
    include('../funcs/funcs.php');
    chkSsid();

    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');

    //POST
    if(!isset($_POST["search"]) && $_POST["search"]==""){
        $s = "";
    }else{
        $s = $_POST["search"];
    }

    // DB接続
    $pdo = db_con();

    // 入力フォームのAjax処理
    if($s != ''){
        $sql = "SELECT * FROM user_table WHERE user_name LIKE :s";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':s','%'.$s.'%',PDO::PARAM_STR);
    } else {
        $sql = "SELECT * FROM user_table";
        $stmt = $pdo->prepare($sql);
    }
    $val = $stmt->execute();

    // データ表示
    $view ='';
    $count = 0;
    if($val === false){
        queryError($stmt);
    } else {
        // while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        //     $view .= '<option value="'.$res['user_name'].'">';            $view .= '</datalist>';
        // }
        // echo $view;
        
        while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
            if($count == 0){
                $view .= '<ul id="list">';
                $view .= '<li name="'.$res['id'].'" class="userlist">';
                $view .= '<a href="#" class="user" id="user'.$res['id'].'">';
                $view .= '<img src="../'.$res['photourl'].'" style="width:50px;height:50px;"><br>';
                $view .= '<span>'.$res['user_name'].'</span>';
                $view .= '<input type="hidden" value="'.$res['id'].'">';
                $view .= '</a>';
                $view .= '</li>';   
            }else if($count % 9 != 0){
                $view .= '<li name="'.$res['id'].'" class="userlist">';
                $view .= '<a href="#" class="user" id="user'.$res['id'].'">';
                $view .= '<img src="../'.$res['photourl'].'" style="width:50px;height:50px;"><br>';
                $view .= '<span>'.$res['user_name'].'</span>';
                $view .= '<input type="hidden" value="'.$res['id'].'">';
                $view .= '</a>';
                $view .= '</li>';
            } else {
                $view .= '</ul>';
                $view .= '<ul id="list">';
                $view .= '<li name="'.$res['id'].'" class="userlist">';
                $view .= '<a href="#" class="user" id="user'.$res['id'].'">';
                $view .= '<img src="../'.$res['photourl'].'" style="width:50px;height:50px;"><br>';
                $view .= '<span>'.$res['user_name'].'</span>';
                $view .= '<input type="hidden" value="'.$res['id'].'">';
                $view .= '</a>';
                $view .= '</li>';
            }
            $count += 1;
        }
        if($count %9 != 0){
            $view .= '</ul>';
        }
        echo $view;
    }
?>