<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続
function db_conn(){
  try {
      //localhostの場合
      $db_name = "gs_db4";    //データベース名
      $db_id   = "root";      //アカウント名
      $db_pw   = "";          //パスワード：XAMPPはパスワード無しに修正してください。
      $db_host = "localhost"; //DBホスト

      //localhost以外＊＊自分で書き直してください！！＊＊ --> DB名は要変更
      if($_SERVER["HTTP_HOST"] != 'localhost'){
          $db_name = "kaichan007_gs_bm";  //データベース名
          $db_id   = "kaichan007";  //アカウント名（さくらコントロールパネルに表示されています）
          $db_pw   = "kaichan07";  //パスワード(さくらサーバー最初にDB作成する際に設定したパスワード)
          $db_host = "mysql57.kaichan007.sakura.ne.jp"; //例）mysql**db.ne.jp...
      }
      return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
  } catch (PDOException $e) {
      exit('DB Connection Error:'.$e->getMessage());
  }
}

//SQLエラー
function sql_error($stmt){
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

//リダイレクト
function redirect($file_name){
    header("Location: ".$file_name);
    exit();
}

//SessionCheck(スケルトン)
function sschk(){
  if($_SESSION["chk_ssid"] != session_id()){
    exit("Login error");
  }else{
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id();
  }
}
