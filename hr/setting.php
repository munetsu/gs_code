<?php
    session_start();

    // 関数読み込み
    include('funcs/funcs.php');
    chkSsid();

    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');

    // ログインユーザーのID取得
    $id = $_SESSION['id'];

    // ユーザー一覧を取得
    $user_all = $_SESSION['user_all'];
    $user_all = json_encode($user_all);
    
    // ユーザー情報の取得
    $pdo = db_con();
    $sql = "SELECT * FROM user_table WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id',$id,PDO::PARAM_INT);
    $val = $stmt->execute();

    if($val === false){
        queryError($stmt);
    }else {
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $jsres = json_encode($res);
    }

    $statement= $pdo->prepare("SELECT * FROM task_table WHERE recipient_id=:id AND status=2");
    $statement->bindValue(':id',$id,PDO::PARAM_INT);
    $value = $statement->execute();

    $count = 0;
    $preview = 0;
    $total = 0;
    if($value === false){
        queryError($statement);
    } else {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($result as $loop){
            $count++;
            $preview += $loop['preview'];
        }

        if($count == 0){
            $total = 0;
        } else {
            $total = $preview / $count;
        }
    }

    // 日付
    $date = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/top.css">
    <link rel="stylesheet" href="css/setting.css">
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
            <div class="main">
                <!-- ユーザー基礎情報 -->
                <div class="userinfo">
                    <div class="userphoto">
                        <img src="<?php echo $res['photourl'];?>" alt="" class="photo"><br>
                        <form action="photo_upload.php" method="POST" enctype="multipart/form-data" id="photofile">
                            <input type="file" name="upfile" class="file">
                            <button type="button" id="submit" value="0">変更する</button>
                        </form>
                    </div>
                    <div class="userdetail">
                        <div class="box">
                            <p class="title">ユーザー名：</p>
                            <span class="detail"><?php echo $res['user_name']?></span>
                        </div>
                        <div class="box">
                            <p class="title">所属部署：</p>
                            <span class="detail"><?php echo $res['department']?></span>
                        </div>
                        <div class="box">
                            <p class="title">処理タスク数：</p>
                            <span class="detail"><?php echo $count?></span>
                        </div>
                        <div class="box">
                            <p class="title">平均評価：</p>
                            <span class="detail"><?php echo $total?></span>
                        </div>
                    </div>
                </div>
                <!-- Todoヒストリー -->
                <div class="history">
                    <h3 class="analytics">完了Todo分析</h3>
                    <div>
                        <h5 class="timezone">期間</h5>
                        <div class="selectdate">
                            <form action="analytics.php" method="post" name="analytics" class="date">
                                <input type="date" value="<?php echo $date?>" name="datestart" id="datestart"> 〜 <input type="date" value="<?php echo $date?>" name="dateend" id="dateend">
                            </form>
                            <a href="#" class="display" id="display">表示する</a>
                        </div>
                    </div>
                    <div class="graph">
                        <div class="grapharea">
                            <h3 class="graphtitle">実施Todo数（依頼者別）</h3>
                            <canvas id="who" style="width:80px;height:80px"></canvas>
                        </div>
                        <div class="grapharea">
                            <h3 class="graphtitle">平均評価（依頼者別）</h3>
                            <canvas id="preview" style="width:80px;height:80px;"></canvas>
                        </div>
                    </div>

                </div>
            </div>
            <!-- フッター -->
            <div class="footer">
                copyright
            </div>
    </div>
    
    <!-- PHP変数の引き継ぎ -->
    <script>
        let userinfo = <?php echo $jsres;?>;
        let user_all = <?php echo $user_all?>;
    </script>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.min.js"></script>
    <script src="js/top.js"></script>
    <script src="js/setting.js"></script>
</body>
</html>
