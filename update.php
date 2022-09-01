<?php
//1. POSTデータ取得
$v_name   = $_POST["v_name"];
$vin_number  = $_POST["vin_number"];
$reg_date = $_POST["reg_date"];
$sales_date    = $_POST["sales_date"]; 
$auction_flag = $_POST["auction_flag"];
$sales_flag = $_POST["sales_flag"];
$tranx_status = $_POST["tranx_status"];
$stockfin_status = $_POST["stockfin_status"];
$id    = $_POST["id"];   //idを取得

/*
<label>車両名: <input type="text" name="v_name" value="<?=$row["vehicle_name"]?>"></label><br>
<label>VIN number: <input type="text" name="vin_number" value="<?=$row["VIN_number"]?>"></label><br>
<label>登録日: <input type="text" name="reg_date" value="<?=$row["purchase_date"]?>"></label><br>
<label>販売日: <input type="text" name="sales_date" value="<?=$row["sales_date"]?>"></label><br>
<label>ステータス（オークション）: <input type="text" name="auction_flag" value="<?=$row["auction_flag"]?>"></label><br>
<label>ステータス（販売）: <input type="text" name="sales_flag" value="<?=$row["sales_flag"]?>"></label><br>
<label>ステータス（取引）: <input type="text" name="tranx_status" value="<?=$row["transaction_status"]?>"></label><br>
<label>車両画像: <img src="<?=$row["image_path"]?>" width="100" height="100"></label><br>
<!-- idを隠して送信 -->
<input type="hidden" name="id" value="<?=$row["id"]?>">
*/

//2. DB接続します
include("funcs.php");  //funcs.phpを読み込む（関数群）
session_start();
sschk();
$pdo = db_conn();      //DB接続関数

//３．データ登録SQL作成
$sql = "update used_stock_table set vehicle_name=:v_name, VIN_number=:vin_number, purchase_date=:reg_date, sales_date=:sales_date, auction_flag=:auction_flag, sales_flag=:sales_flag, transaction_status=:tranx_status, stockfin_flg=:stockfin_status where id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':v_name',  $v_name,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':vin_number', $vin_number,  PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':reg_date',   $reg_date,    PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':sales_date',$sales_date, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':auction_flag',$auction_flag, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':sales_flag',$sales_flag,  PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':tranx_status',$tranx_status, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':stockfin_status',$stockfin_status, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id',$id,  PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    redirect("select.php");
}
?>
