<?php
//1. POSTデータ取得
$stockfin_flg = $_POST["stockfin_flg"];
$id    = $_POST["id"];   //idを取得

/*
     <label>車両名:<?=$row["vehicle_name"]?></label><br>
     <label>VIN number: <?=$row["VIN_number"]?></label><br>
     <label>登録日: <?=$row["purchase_date"]?></label><br>
     <label>ステータス更新（許可=2/却下=0）: <input type="text" name="stockfin_flg" value="<?=$row["stockfin_flg"]?>"></label><br>    
     <label>車両画像: <img src="<?=$row["image_path"]?>" width="100" height="100"></label><br>
    <!-- idを隠して送信 -->
     <input type="hidden" name="id" value="<?=$row["id"]?>">
*/

//2. DB接続します
include("funcs.php");  //funcs.phpを読み込む（関数群）
sschk();
$pdo = db_conn();      //DB接続関数

//３．データ登録SQL作成
$sql = "update used_stock_table set stockfin_flg=:stockfin_flg where id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':stockfin_flg',$stockfin_flg, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id',$id,  PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)

/*
$stmt = $pdo->prepare("insert into used_stock_table(vehicle_name, VIN_number, owner_id, purchase_date, image_path) values(:vehicle_name, :VIN_number, :owner_id, :purchase_date, :image_path)");
$stmt->bindValue(':vehicle_name', $v_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':VIN_number', $v_number, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':owner_id', $_SESSION["name"], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':purchase_date', date("Y-m-d"), PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':image_path', "files/".$_FILES["upfile"]["name"], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
*/

$status = $stmt->execute(); //実行


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    $test_alert = "<script type='text/javascript'>alert('在庫ファイナンス申請処理が完了しました！');</script>";
    echo $test_alert;
    echo '<script>location.href = "select.php";</script>';
    //redirect("select.php");
}
?>
