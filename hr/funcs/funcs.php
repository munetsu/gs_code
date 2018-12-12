<?php
/** 共通で使うものを別ファイルにしておきましょう。*/

//DB接続関数（PDO）
function db_con(){
  $dbname='hr';
  $id='root';
  $pw='';
  $host='localhost';
  try {
    $pdo = new PDO('mysql:dbname='.$dbname.';charset=utf8;host='.$host,$id,$pw);
  } catch (PDOException $e) {
    exit('DbConnectError:'.$e->getMessage());
  }
  return $pdo;
}

//SQL処理エラー
function queryError($stmt){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}

/**
* XSS
* @Param:  $str(string) 表示する文字列
* @Return: (string)     サニタイジングした文字列
*/
function h($str){
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

// SESSION比較を実行
function chkSsid(){
  if(!isset($_SESSION['chk_ssid']) || 
    $_SESSION['chk_ssid'] != session_id() //前ページで発行されたセッションIDと比較
  ){
    exit('不正アクセスです/Login Error!!');
  } else {
    session_regenerate_id(true);
    $_SESSION['chk_ssid'] = session_id();
  }
}

//前後にある半角全角スペースを削除する関数
function spaceTrim ($str) {
	// 行頭
	$str = preg_replace('/^[ 　]+/u', '', $str);
	// 末尾
	$str = preg_replace('/[ 　]+$/u', '', $str);
	return $str;
}

?>
