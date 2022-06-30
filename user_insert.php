<?php

$name = $_POST["name"];
$id = $_POST["id"];
$pass = $_POST["pass"];
$kanri = $_POST["kanri"];

//2. DB接続します
include("funcs.php");
sschk();
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("insert into gs_user_table(name, lid, lpw, kanri_flg) values(:name, :lid, :lpw, :kanri)");
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid', $id, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lpw', password_hash($pass, PASSWORD_DEFAULT), PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':kanri', $kanri, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute();



//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("user.php");
}
?>
