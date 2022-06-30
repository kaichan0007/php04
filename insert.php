<?php
require_once 'C:/xampp/vendor/autoload.php';
use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;

// 文字コードを設定する。
// 日本語だと文字コードの自動解析がうまく動かないようなので、
// ページに合わせて設定する必要があります
$options = new Options();
$options->setEnforceEncoding('utf8');

// ページを解析
$url = 'https://www.release.tdnet.info/inbs/I_list_001_'.$_POST["date"].'.html';
$dom = new Dom();
$dom->loadFromUrl($url, $options);

$c_code = $_POST["company_code"];

// 商品名を取得
$aaa = $dom->find('td');

$c_name="";
$kaiji_title="";
$kaiji_url="";

for($i=0; $i<count($aaa); $i++)
{
    //echo $aaa[$i]."\n";
    if(strcmp($aaa[$i]->text,$c_code)==0){
        //echo "見つけました！";
        //echo $aaa[$i+1];
        //echo $aaa[$i+2];
        //echo $aaa[$i+2]->firstChild()->getAttribute("href");

        //$str = $aaa[$i+1]->text.",".$aaa[$i+2]->firstChild()->text.",".$aaa[$i+2]->firstChild()->getAttribute("href")."\n";

        $c_name = $aaa[$i+1]->text;
        $kaiji_title = $aaa[$i+2]->firstChild()->text;
        $kaiji_url = $aaa[$i+2]->firstChild()->getAttribute("href");
    }
}

//PDFの解析(1)
$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile('https://www.release.tdnet.info/inbs/'.$kaiji_url);
//$pdf    = $parser->parseFile('E002078.pdf');
//echo $pdf->getText();


//PDFの解析(2)
//use \Spatie\PdfToText\Pdf;
//$pdf2 = Pdf::getText("E002078.pdf");
//$pdf2 = (new Pdf())
//    ->setPdf('php03.pdf')
//    ->text();
//echo $pdf2;

//echo 'https://www.release.tdnet.info/inbs/'.$kaiji_url;

//echo mb_convert_encoding($pdf->getText(), 'SJIS-win', 'UTF-8');

//echo $pdf->getText();

$keyword = $_POST["search_key"];

$count = substr_count($pdf->getText(), $keyword);

//2. DB接続します
include("funcs.php");
sschk();
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("insert into gs_bm_table(c_name, title, url, content, count) values(:c_name, :title, :url, :content, :count)");
$stmt->bindValue(':c_name', $c_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':title', $kaiji_title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':url', $kaiji_url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':content', $pdf->getText(), PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':count', $count, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute();



//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("index.php");
}
?>
