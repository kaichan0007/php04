<?php
$id = $_GET["id"]; //?id~**を受け取る
include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
$stmt   = $pdo->prepare("SELECT * FROM used_stock_table WHERE id=:id" ); //SQLをセット
$stmt->bindValue(':id',   $id,    PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入

//３．データ表示
if($status==false) {
    sql_error($stmt);
}else{
    $row = $stmt->fetch();
}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">
                        <img src="files\HatchfulExport-All\logo_transparent.png" alt="Urusan Inventori Mobil" width="50">
                    </div>
                    <div class="navbar-header"><a class="navbar-brand" href="select.php">車両データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="update.php">
  <div class="jumbotron">
   <fieldset>
   <legend>在庫情報一覧</legend>
     <label>車両名: <input type="text" name="v_name" value="<?=$row["vehicle_name"]?>"></label><br>
     <label>VIN number: <input type="text" name="vin_number" value="<?=$row["VIN_number"]?>"></label><br>
     <label>登録日: <input type="text" name="reg_date" value="<?=$row["purchase_date"]?>"></label><br>
     <label>販売日: <input type="text" name="sales_date" value="<?=$row["sales_date"]?>"></label><br>
     <label>ステータス（売却済み default=0/売却済=1）: 
     <input type="text" name="sales_flag" value="<?=$row["sales_flag"]?>">
      </label><br>
     <label>ステータス（オークション default=0/出品中=1）: <input type="text" name="auction_flag" value="<?=$row["auction_flag"]?>"></label><br>
     <label>ステータス（ディーラー間取引 default=0/申請中=1/相手DLR承認済(手付金待ち)=2）: <input type="text" name="tranx_status" value="<?=$row["transaction_status"]?>"></label><br>
     <label>ステータス（在庫ファイナンス default=0/申請中=1/Disburse済=2）: <input type="text" name="stockfin_status" value="<?=$row["stockfin_flg"]?>"></label><br>
     <label>車両画像: <img src="<?=$row["image_path"]?>" width="100" height="100"></label><br>
    <!-- idを隠して送信 -->
     <input type="hidden" name="id" value="<?=$row["id"]?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->



</body>
</html>
