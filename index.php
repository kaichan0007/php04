<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>車両データ登録</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/table.css" rel="stylesheet">
            
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
                    <div class="navbar-header"><a class="navbar-brand" href="login.php">ログイン</a></div>
                    <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
                    <?php 
                        session_start();
                        //echo $_SESSION["kanri_flg"];
                        if($_SESSION["kanri_flg"]==1) {
                            echo '<div class="navbar-header"><a class="navbar-brand" href="user.php">ユーザー登録</a></div>
                            <div class="navbar-header"><a class="navbar-brand" href="user_select.php">ユーザー一覧</a></div>';
                        }
                        else if($_SESSION["kanri_flg"]==0) {
                            echo '<div class="navbar-header"><a class="navbar-brand" href="select_others.php">他DLR在庫一覧</a></div>';
                        }
                    ?>
                </div>
            </nav>
        </header>
        <!-- Head[End] -->

        <!-- Main[Start] -->
        <form method="POST" action="insert.php" enctype="multipart/form-data">
            <div class="jumbotron">
            <fieldset>
            <legend>車両データを登録します。</legend>
                <label>車両名: <input type="text" name="vehicle_name"></label><br>
                <label>VINナンバー: <input type="text" name="VIN_number"></label><br>
                <label>車両画像: <input type="file" name="upfile"></label><br>
                <input type="submit" value="送信">
                </fieldset>
            </div>
        </form>
        <!-- Main[End] -->


    </body>
</html>
