<?php
    session_start();
    // 関数読み込み
    include('../funcs/funcs.php');
    chkSsid();

    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');

    // ログインユーザーのID取得
    $id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/top.css">
    <link rel="stylesheet" href="../css/create.css">
</head>
<body>
    <!-- ヘッダー -->
    <div class="header">
        <!-- ロゴ -->
        <div class="logoarea">
            <img src="../img/logo.png" alt="" id="logo">
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
                <img src="../img/side.svg" alt="" class="sideicon">
            </div>
        </div>
    </div>

    <div class="mainarea">
        <div class="leftarea">
            <!-- ナビ -->
            <div class="menu">
                <ul>
                    <li><a href="../top.php" class="menu_a"><img src="../img/allicon.svg" class="menuicon" id="menuicon1"><span class="hovertext">全体</span></a></li>
                    <li><a href="#" class="menu_a"><img src="../img/notdoing.svg" class="menuicon" id="menuicon2"><span class="hovertext">未着手</span></a></li>
                    <li><a href="#" class="menu_a"><img src="../img/doing.svg" class="menuicon" id="menuicon3"><span class="hovertext">着手中</span></a></li>
                    <li><a href="#" class="menu_a"><img src="../img/finish.svg" class="menuicon" id="menuicon4"><span class="hovertext">完了</span></a></li>
                    <li><a href="../setting.php" class="menu_a"><img src="../img/setting.svg" class="menuicon" id="menuicon5"><span class="hovertext">設定</span></a></li>
                </ul>
            </div>
        </div>
        <div class="rightarea">
            <div class="main">
                <form action="task_create.php" method="post" name="task">
                    <div class="itemlist">
                        <p class="item">Todo名</p>
                        <input type="text" name="title" id="title">
                    </div>
                    <div class="itemlist">
                        <p class="item">重要度</p>
                        <label><input type="radio" name="important" id="important" class="important" value="1">緊急かつ重要</label>
                        <label><input type="radio" name="important" id="important" class="important" value="2">緊急ではないが重要</label>
                        <label><input type="radio" name="important" id="important" class="important" value="3">緊急だが重要ではない</label>
                        <label><input type="radio" name="important" id="important" class="important" value="4">緊急かつ重要ではない</label>
                    </div>
                    <div class="itemlist">
                        <p class="item">いつまで</p>
                        <input type="date" name="deadline" id="deadline" class="inputarea">
                        <a href="#" id="timebtn" class="addbtn">＋時間</a>
                        <input type="time" name="deadtime" id="deadtime" style="display:none" class="inputarea">
                    </div>
                    <div class="itemlist">
                        <p class="item">だれに</p>
                        <input type="text" name="recipient" id="recipient" autocomplete="on" list="nameList" class="inputarea"><a href="#" id="namesearch" class="addbtn">検索</a>
                        <input type="hidden" id="rec_no" name="rec_no">
                    </div>
                    <div class="photolist close" id="photolist">
                    <!-- <datalist id="nameList"></datalist> -->
                        
                    </div>
                    
                    <div class="itemlist">
                        <p class="item">詳細</p>
                        <textarea id="detail" name="detail" cols="100" rows="5" class="textarea"></textarea>
                    </div>
                </form>
                <div class="submitzone">
                    <a href="javascript:void(0)" id="submitbtn">作成する</a>
                </div>
            </div>

            <!-- フッター -->
            <div class="footer">
                copyright
            </div>
        </div>
    </div>    

    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
    <script src="../js/task_create.js"></script>
    <script src="../js/top.js"></script>
</body>
</html>