<?php
//0. SESSION開始！！
session_start();

//１．関数群の読み込み
include("funcs.php");

//LOGINチェック → funcs.phpへ関数化しましょう！
//if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
//    exit("Login Error");
//}else{
//    session_regenerate_id(true);
//    $_SESSION["chk_ssid"] = session_id();
//}
sschk();

//２．データ登録SQL作成
$pdo = db_conn();
$stmt   = $pdo->prepare("SELECT * FROM gs_user_table"); //SQLをセット
$status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入

//３．データ表示
$view=""; //HTML文字列作り、入れる変数
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  //SQL成功の場合
  $view .= "<table><tr> <th>No.</th> <th>名前</th> <th>ID</th> <th>パスワード</th> <th>管理者Flag</th> </tr>";
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ //データ取得数分繰り返す
    //以下でリンクの文字列を作成, $r["id"]でidをdetail.phpに渡しています
    $view .= "<tr>";
    $view .= "<td>".h($r["id"])."</td><td>".h($r["name"])."</td><td>".h($r["lid"])."</td><td>".h($r["lpw"])."</td><td>".h($r["kanri_flg"])."</td>";
    $view .= "</tr>";
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ユーザー一覧</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/table.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
                        <img src="files\HatchfulExport-All\logo_transparent.png" alt="Urusan Inventori Mobil" width="50">
      </div>
      <div class="navbar-header">
      <a class="navbar-brand" href="user.php">ユーザー登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>