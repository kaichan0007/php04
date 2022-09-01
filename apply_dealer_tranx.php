<?php
//1. POSTデータ取得
$id = $_GET["id"];

//2. DB接続します
include("funcs.php");
$pdo = db_conn();

//３．データ更新SQL作成（ディーラー間取引ステータス、申請DLR情報更新）
$sql = "update used_stock_table set transaction_status=1, transaction_dealer=:tranx_dealer where id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
session_start();
$stmt->bindValue(':tranx_dealer', $_SESSION["name"], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  $test_alert = "<script type='text/javascript'>alert('他DLR在庫の買取申請を受領しました！手付金をXXXXまでお振込みください。');</script>";
  echo $test_alert;
  echo '<script>location.href = "select_others.php";</script>';
  //redirect("select_others.php");
}
?>