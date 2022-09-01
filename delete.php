<?php
//1. POSTデータ取得
$id = $_GET["id"];

//2. DB接続します
include("funcs.php");
$pdo = db_conn();

//３．データ更新SQL作成（売却Flag, 売却日更新）
$sql = "update used_stock_table set sales_flag=1, sales_date=:sales_date where id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':sales_date', date("Y-m-d"), PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  $test_alert = "<script type='text/javascript'>alert('在庫の売却処理が完了しました！');</script>";
  echo $test_alert;
  echo '<script>location.href = "select.php";</script>';
  //redirect("select.php");
}
?>
