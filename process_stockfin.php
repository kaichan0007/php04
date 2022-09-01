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
  <title>在庫ファイナンスリスクスト処理</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
                    <div class="navbar-header"><a class="navbar-brand" href="select.php">車両データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="process_stockfin2.php">
  <div class="jumbotron">
   <fieldset>
   <legend>在庫ファイナンスリクエスト処理</legend>
     <label>車両名:<?=$row["vehicle_name"]?></label><br>
     <label>VIN number: <?=$row["VIN_number"]?></label><br>
     <label>登録日: <?=$row["purchase_date"]?></label><br>
     <label>ステータス更新（許可=2/却下=0）: 
     
     <select name='stockfin_flg'>
      <option value='2'>許可</option>
      <option value='0'>却下</option>
     </select>
     
     </label><br>    
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