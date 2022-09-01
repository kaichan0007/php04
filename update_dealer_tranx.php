<?php
//1. POSTデータ取得
$tranx_status = $_POST["tranx_status"];
$id    = $_POST["id"];   //idを取得

/*
     <label>車両名:<?=$row["vehicle_name"]?></label><br>
     <label>VIN number: <?=$row["VIN_number"]?></label><br>
     <label>登録日: <?=$row["purchase_date"]?></label><br>
     <label>DLR名: <?=$row["transaction_dealer"]?></label><br>
     <label>ステータス更新（許可=2、却下=4）: <input type="text" name="tranx_status" value="<?=$row["transaction_status"]?>"></label><br>    
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
$sql = "update used_stock_table set transaction_status=:tranx_status where id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':tranx_status',$tranx_status, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id',$id,  PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    $test_alert = "<script type='text/javascript'>alert('他DLRリクエスト処理が完了しました！');</script>";
    echo $test_alert;
    echo '<script>location.href = "select.php";</script>';
    //redirect("select.php");
}
?>
