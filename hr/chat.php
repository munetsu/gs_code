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

    // ログインユーザー情報取得
    $statement = $pdo->prepare("SELECT * FROM user_table WHERE id = $id");
    $res = $statement->execute();
    if($res === false){
        queryError($statement);
    } else {
        $value = $statement->fetch(PDO::FETCH_ASSOC);
        $luser = $value['user_name'];
        $lurl = $value['photourl'];
    }


    // タスクデータ取得
    $sql = "SELECT * FROM task_table INNER JOIN user_table ON task_table.client_id = user_table.id WHERE task_id = $task_id";
    $stmt = $pdo->prepare($sql);
    $val = $stmt->execute();

    if($val === false){
        queryError($stmt);
    } else {
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // var_dump($res);
    // exit;

    // DBデータの変数化
    $name = $res['name'];
    $deadline = $res['deadline'];
    $deadtime = $res['deadtime'];
    $important = $res['important'];
    $detail = $res['detail'];
    $url = $res['url'];
    $username = $res['user_name'];
    $userurl = $res['photourl'];
    $client = array(
        "todo" => $res['name'],
        "cid" => $res['id'],
        "name" => $res['user_name'],
        "photourl" => $res['photourl']
    );
    $client = json_encode($client);

    $loginuser = array(
        "lid" => $id,
        "luser" => $luser,
        'lurl' => $lurl
    );

    $loginuser = json_encode($loginuser);

    $importance = ["","重要だが緊急ではない","重要かつ緊急","緊急だが重要ではない","緊急でも重要でもない"];

    
    // 日付取得
    $date = date('Y/m/d');
    $date = strval($date);
    $date = json_encode($date);
    // var_dump($client);
    // exit; 
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
    <link rel="stylesheet" href="css/message.css">
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
                    <li class="list hide"><a href="">依頼リスト</a></li>
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
                <!-- todo部分 -->
                <div class="todo">
                    <div class="itemarea">
                        <p class="item">Todo：</p>
                        <p class="itemdetail"><?php echo $name?></p>
                    </div>
                    <div class="itemarea">
                        <p class="item">期限：</p>
                        <p class="itemdetail"><?php echo $deadline?>／<?php echo $deadtime?></p>
                    </div>
                    <div class="itemarea">
                        <p class="item">重要度：</p>
                        <p class="itemdetail"><?php echo $importance[$important]?></p>
                    </div>
                    <div class="itemarea">
                        <p class="item">作成者：</p>
                        <div class="person">
                            <img src="<?php echo $userurl?>" alt="" class="uimg">
                            <span><?php echo $username?></span>
                        </div>
                    </div>
                    <div class="other">
                        <p class="item">詳細：</p>
                        <p class="otherdetail"><?php echo $detail?></p>
                    </div>
                    <div class="itemarea">
                        <p class="item">添付ファイル：</p>
                        <p class="itemdetail">添付ファイルあり</p>
                        <div>
                        <?php if($url ==''){ ?>
                        <form method="POST" action="file_upload.php" enctype="multipart/form-data">
                            <input type="file" name="upfile">
                            <input type="hidden" name="task_id" value="<?php echo $task_id?>">
                            <input type="submit" name="submit" value="送信">
                        </form>
                        <?php }?>
                        </div>
                    </div>
                    <div class="finish">
                        <form action="task_update.php" method="post">
                            <input type="hidden" name="task_id" value="<?php echo $task_id?>">
                            <button class="finishbtn">完了</button>
                        </form>
                    </div>


                </div>
                <!-- Message部分 -->
                <div class="message">
                    <div class="talktitle">
                        <p><?php echo $name; ?></p>
                    </div>
                    <div class="chatbody" id="chatbody"></div>
                    <div class="inputarea">
                        <textarea id="mes" cols="40" placeholder="テキスト入力" wrap="hard"></textarea>
                        <button id="submit">送信</button>
                    </div>
                </div>
            </div>
        
            <!-- フッター -->
            <div class="footer">
                copyright
            </div>
        </div>
    </div>
    
    <!-- PHP変数に引き渡し -->

    <script>
        let loginuser = <?php echo $loginuser; ?>;
        let client = <?php echo $client; ?>;
        let date = <?php echo $date; ?>;
    </script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <!-- Firebase -->
    <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
        apiKey: "AIzaSyArWIbAcNbPCYuk104IAFiBLSIgMFO1PW0",
        authDomain: "worklight-9e90e.firebaseapp.com",
        databaseURL: "https://worklight-9e90e.firebaseio.com",
        projectId: "worklight-9e90e",
        storageBucket: "worklight-9e90e.appspot.com",
        messagingSenderId: "1030877434763"
        };
firebase.initializeApp(config);
    </script>
    <script src="js/firebase.js"></script>
</body>
</html>