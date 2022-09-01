<?php
require_once 'C:/xampp/vendor/autoload.php';

session_start();

$v_name = $_POST["vehicle_name"];
$v_number = $_POST["VIN_number"]; 

//↓uploadファイルの有り無し確認
if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
  //↓有効なファイルかどうかを検証し、問題なければ名前を変更しアップロード完了
  if (move_uploaded_file($_FILES["upfile"]["tmp_name"], "files/" . $_FILES["upfile"]["name"])) {
  chmod("files/" . $_FILES["upfile"]["name"], 0644); //パーミッション設定
  echo $_FILES["upfile"]["name"] . "をアップロードしました。";
  } else {
  echo "ファイルをアップロードできません。";
  }
  } else {
  echo "ファイルが選択されていません。";
  }

//2. DB接続します
include("funcs.php");
sschk();
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("insert into used_stock_table(vehicle_name, VIN_number, owner_id, purchase_date, image_path) values(:vehicle_name, :VIN_number, :owner_id, :purchase_date, :image_path)");
$stmt->bindValue(':vehicle_name', $v_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':VIN_number', $v_number, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':owner_id', $_SESSION["name"], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':purchase_date', date("Y-m-d"), PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':image_path', "files/".$_FILES["upfile"]["name"], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("index.php");
}
?>
