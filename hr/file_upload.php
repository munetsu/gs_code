<?php
session_start();

// 関数読み込み
include('funcs/funcs.php');
chkSsid();

// POST情報
$task_id = $_POST['task_id'];

// ファイルアップロードの上限サイズはphp.iniで設定(post_max_size),upload_max_size
// 本番サービスは、display_errorsはOffにする

//Fileアップロードチェック
if (isset($_FILES["upfile"] ) && $_FILES["upfile"]["error"] ==0 ) {
    //情報取得
    $file_name = $_FILES["upfile"]["name"];         //"1.jpg"ファイル名取得
    $tmp_path  = $_FILES["upfile"]["tmp_name"]; //"/usr/www/tmp/1.jpg"アップロード先のTempフォルダ
    $file_dir_path = "file/";  //画像ファイル保管先

    //***File名の変更***
    $extension = pathinfo($file_name, PATHINFO_EXTENSION); //拡張子取得(jpg, png, gif)
    $uniq_name = date("YmdHis").md5(session_id()) . "." . $extension;  //ユニークファイル名作成
    // $file_name = $file_dir_path.$uniq_name; //ユニークファイル名とパス
   
    // FileUpload [--Start--]
    if ( is_uploaded_file( $tmp_path ) ) {
        if ( move_uploaded_file( $tmp_path, $file_dir_path.$uniq_name ) ) {
            chmod( $file_dir_path.$uniq_name, 0644 );
        } else {
            $img = "Error:アップロードできませんでした。"; //Error文字
            exit;
        }
    }
    // FileUpload [--End--]

    // DB登録
    $pdo = db_con();
    $sql = "UPDATE task_table SET url = :url WHERE task_id = $task_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':url',$file_dir_path.$uniq_name,PDO::PARAM_STR);
    $val = $stmt->execute();

    if($val === false){
        queryError($stmt);
        exit;
    }

    header('Location: chat.php');
    exit;
}
?>
