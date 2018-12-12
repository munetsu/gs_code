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
    
    // DB情報取得
    $statement = $pdo->prepare("SELECT * FROM user_table");
    $result = $statement->execute();
    if($result === false){
        queryError($statement);
    } else {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $con){
            $user_list[] = $con['user_name'];
        }
        // セッションに入れる
        $_SESSION['user_all'] = $user_list;
        $user_list = json_encode($user_list);
    }


    // 受託中のタスク情報取得
    $stmt = $pdo->prepare("SELECT * FROM task_table WHERE recipient_id= :id AND (status=0 OR status=1)");
    $stmt->bindValue(':id',$id,PDO::PARAM_INT);
    $val = $stmt->execute();

    $count = 0;
    $get = 5;
    if($val === false){
        queryError($stmt);
    } else {
        $res = $stmt->fetchAll(PDO:: FETCH_ASSOC);
        foreach($res as $loop){
            if($loop['important'] == 1){
                $first[] = $loop;
            } else if($loop['important'] == 2){
                $second[] = $loop;
            } else if($loop['important'] == 3){
                $third[] = $loop;
            } else if($loop['important'] == 4){
                $fourth[] = $loop;
            }
        }
    }

    if(!empty($first)){
        $first = json_encode($first);
    } else {
        $first = '1';
    }

    if(!empty($second)){
        $second = json_encode($second);
    } else {
        $second = '1';
    }

    if(!empty($third)){
        $third = json_encode($third);
    } else {
        $third = '1';
    }

    if(!empty($fourth)){
        $fourth = json_encode($fourth);
    } else {
        $fourth = '1';
    }
    
    // 日付取得
    $date1 =date('Ymd');
    $date2 = date('Hi');

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
                    <li class=list><a href="">受託リスト</a></li>
                    <li class="list hide"><a href="top_change.php" id="sidechange">依頼リスト</a></li>
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
                <li><a href="#" class="menu_a"><img src="img/finish.svg" class="menuicon" id="menuicon4"><span class="hovertext">完了</span></a></li>
                <li><a href="setting.php" class="menu_a"><img src="img/setting.svg" class="menuicon" id="menuicon5"><span class="hovertext">設定</span></a></li>
            </ul>
        </div>
        </div>

        <div class="rightarea">
            <!-- メイン -->
            <div class="main">
            <h3 class="uppertext">重要度(高)</h3>
            <h3 class="undertext">緊急度(高)</h3>
                <div class="upper">
                    <!-- 第一象限 -->
                    <div class="first">
                    <!-- <a href="#" class="more" id="morefirst" data-value="1">すべて見る</a> -->
                    </div>
                    <!-- 第二象限 -->
                    <div class="second">
                    <!-- <a href="#" class="more" id="moresecond" data-value="2">すべて見る</a> -->
                    </div>
                </div>
                <div class="under">
                    <!-- 第三象限 -->
                    <div class="third">
                        <!-- <a href="#" class="more" id="morethird" data-value="3">すべて見る</a> -->
                    </div> 
                    <!-- 第四象限 -->
                    <div class="fourth">
                        <!-- <a href="#" class="more" id="morefourth" data-value="4">すべて見る</a> -->
                    </div>
                    <div class="create">
                        <a href="create/create.php"><img src="img/create.svg" alt="" class="createbtn"></a>
                    </div>
                </div>
            </div>
        
            <!-- フッター -->
            <div class="footer">
                copyright
            </div>
        </div>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    
    <script>
        let first = <?php echo $first; ?>;
        let second = <?php echo $second; ?>;
        let third = <?php echo $third; ?>;
        let fourth = <?php echo $fourth; ?>;
    </script>
        
    <script>
        // PHP変数を引き継ぎ
        let date1 = <?php echo $date1; ?>;
        let date2 = <?php echo $date2; ?>;
        let user_list = <?php echo $user_list; ?>;
        let user_id = <?php echo $id; ?>;
    </script>
    <script src="js/top.js"></script>
    <script src="js/top_list.js"></script>
</body>
</html>

