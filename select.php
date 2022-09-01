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
$stmt   = $pdo->prepare("SELECT * FROM used_stock_table"); //SQLをセット
$status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入

//３．データ表示
$view=""; //HTML文字列作り、入れる変数
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
   //SQL成功の場合
  if($_SESSION["kanri_flg"]==1){ //管理者の場合 
    $view .= "<table><tr> <th>所有DLR</th> <th>車両名</th> <th>VINナンバー</th> <th>購入日</th> <th>売却日</th> <th>オークション出品Flag</th> <th>ディーラー間取引Status</th> <th>在庫ファイナンスFlag</th> <th>車両画像</th> <th>アクション</th> </tr>";
    while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ //データ取得数分繰り返す
      $view .= "<tr>";
      $view .= "<td>".h($r["owner_id"])."</td>"."<td>".h($r["vehicle_name"])."</td>"."<td>".h($r["VIN_number"])."</td>"."<td>".h($r["purchase_date"])."</td>"."<td>".h($r["sales_date"])."</td>"."<td>".h($r["auction_flag"])."</td>"."<td>".h($r["transaction_status"])."</td>"."<td>".h($r["stockfin_flg"])."</td>"."<td><img src=".h($r["image_path"]).' width="100" height="100"></td>'."<td>".'<a href="detail.php?id='.h($r["id"]).'">[データ更新]</a>';
      
      //アクションの設定(売却済みでない場合)
      if(h($r["sales_flag"])!=1){
        if(h($r["transaction_status"])==2){
          $view .= '<a href="process_dealer_tranx.php?id='.h($r["id"]).'">[ディーラー間取引手続き]</a>';
        }
        
        if(h($r["stockfin_flg"])==1){
          $view .= '<a href="process_stockfin.php?id='.h($r["id"]).'">[在庫ファイナンス手続き]</a>';
        }
        
        if(h($r["auction_flag"])==1){
          $view .= '<a href="process_auction.php?id='.h($r["id"]).'">[オークション手続き]</a>';
        }
    }    
      
      $view .= "</td>";
      $view .= "</tr>";      
    }

  }else{ //非管理者の場合
    $view .= "<table><tr> <th>車両名</th> <th>VINナンバー</th> <th>購入日</th> <th>車両画像</th> <th>アクション</th> </tr>";
    while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ //データ取得数分繰り返す
      if($_SESSION["name"]==$r["owner_id"] && $r["sales_flag"]!=1){ //自分のIDの在庫のみ参照、売却済み在庫除く
        $view .= "<tr>";
        $view .= "<td>".h($r["vehicle_name"])."</td>"."<td>".h($r["VIN_number"])."</td>"."<td>".h($r["purchase_date"])."</td>"."<td><img src=".h($r["image_path"]).' width="100" height="100"></td>';
        
        //アクションの設定
        $view .= "<td>";

        if(h($r["transaction_status"])==0){
          $view .= '<a href="delete.php?id='.h($r["id"]).'">[売却]</a>';
        }
        else if(h($r["transaction_status"])==1){
          $view .= '<a href="detail_dealer_tranx.php?id='.h($r["id"]).'">[他DLRリクエスト処理]</a>';
        }
        else if(h($r["transaction_status"])==2){
          $view .= "[手付金確認待ち]";
        }

        if(h($r["stockfin_flg"])==0){
          $view .= '<a href="apply_stockfin.php?id='.h($r["id"]).'">[在庫ファイナンス申請]</a>';
        }
        else if(h($r["stockfin_flg"])==1){
          $view .= '[在庫ファイナンス申請中]';
        }
        else if(h($r["stockfin_flg"])==2){
          $view .= '[在庫ファイナンス適用中]';
        }              

        if(h($r["auction_flag"])==0){
          $view .= '<a href="apply_auction.php?id='.h($r["id"]).'">[オークション出品申請]</a>';
        }
        else if(h($r["auction_flag"])==1){
          $view .= '[オークション出品中]';
        }        
        
        $view .= "</td>";
        $view .= "</tr>";      
      }
    }
  }

 /*
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ //データ取得数分繰り返す
    if($_SESSION["kanri_flg"]==1 || ($_SESSION["kanri_flg"]==0 && $_SESSION["name"]==$r["owner_id"] && $r["sales_flag"]!=1)) { //kanri_flagが無いと、自分のIDの在庫のみ参照、売却済み在庫除く
      //以下でリンクの文字列を作成, $r["id"]でidをdetail.phpに渡しています
      $view .= '<a href="detail.php?id='.h($r["id"]).'">';
      if($_SESSION["kanri_flg"]==1) {     //kanri_flagの有る無しで、Owner IDの表示有無を変更する必要有り
        $view .= h($r["owner_id"]).",";  
      }
      $view .= h($r["vehicle_name"]).", ".h($r["VIN_number"]).", ".h($r["purchase_date"]).", ".h($r["sales_date"]).", ".h($r["auction_flag"]).", ".h($r["sales_flag"]).", ".h($r["transaction_status"]);
      $view .= '</a>';
      $view .= '<img src='.h($r["image_path"]).' width="100" height="100">';
      if(h($r["transaction_status"])==1){
        $view .= '<a href="detail_dealer_tranx.php?id='.h($r["id"]).'">[他DLRリクエスト処理]</a>';
      }
      $view .= '<a href="delete.php?id='.h($r["id"]).'">';
      $view .= "[売却]<br>";
      $view .= '</a>';
    }
  }
*/
  $view .= "</table>";
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>在庫情報一覧</title>
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
      <a class="navbar-brand" href="index.php">データ登録</a>
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
