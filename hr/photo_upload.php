<?php
    session_start();

    // 関数読み込み
    include('funcs/funcs.php');
    chkSsid();

    //クリックジャッキング対策
    header('X-FRAME-OPTIONS: SAMEORIGIN');

    // ログインユーザーのID取得
    $id = $_SESSION['id'];

    //Fileアップロードチェック
    if (isset($_FILES["upfile"] ) && $_FILES["upfile"]["error"] ==0 ) {
        //情報取得
        $file_name = $_FILES["upfile"]["name"];         //"1.jpg"ファイル名取得
        $tmp_path  = $_FILES["upfile"]["tmp_name"]; //"/usr/www/tmp/1.jpg"アップロード先のTempフォルダ
        $file_dir_path = "upload/";  //画像ファイル保管先

        //***File名の変更***
        $extension = pathinfo($file_name, PATHINFO_EXTENSION); //拡張子取得(jpg, png, gif)
        $uniq_name = $id . "." . $extension;  //ユニークファイル名作成
        // $file_name = $file_dir_path.$uniq_name; //ユニークファイル名とパス
    
        // FileUpload [--Start--]
        if ( is_uploaded_file( $tmp_path ) ) {
            if ( move_uploaded_file( $tmp_path, $file_dir_path.$uniq_name ) ) {
                chmod( $file_dir_path.$uniq_name, 0644 );
            } else {
                echo '<script>alert("写真変更ができませんでした");location.href="setting.php;</script>';
            }
        }
    // FileUpload [--End--]
    }

    
    // user_tableの書き換え
    $pdo = db_con();
    $sql = "UPDATE user_table SET photourl = :url WHERE id = $id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':url',$file_dir_path.$uniq_name,PDO::PARAM_STR);
    // var_dump($file_dir_path.$uniq_name);
    // exit;
    $val = $stmt->execute();
    if($val === false){
        queryError($stmt);
    } else {
        echo '<script>alert("写真変更が完了しました");location.href="setting.php";</script>';
    }
?>