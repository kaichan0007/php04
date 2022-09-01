<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>ユーザー登録</title>
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
                    <div class="navbar-header"><a class="navbar-brand" href="login.php">ログイン</a></div>
                    <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
                    <?php if($_SESSION["kanri_flg"]=1) : ?>
                        <div class="navbar-header"><a class="navbar-brand" href="user.php">ユーザー登録</a></div>
                        <div class="navbar-header"><a class="navbar-brand" href="user_select.php">ユーザー一覧</a></div>
                    <?php endif; ?>
                </div>
            </nav>
        </header>
        <!-- Head[End] -->

        <!-- Main[Start] -->
        <form method="POST" action="user_insert.php">
            <div class="jumbotron">
            <fieldset>
            <legend>ユーザー登録します。</legend>
                <label>名前: <input type="text" name="name"></label><br>
                <label>ID: <input type="text" name="id"></label><br>
                <label>パスワード: <input type="text" name="pass"></label><br>
                <label>管理者(1 or 0): <input type="text" name="kanri"></label><br>
                <input type="submit" value="送信">
                </fieldset>
            </div>
        </form>
        <!-- Main[End] -->


    </body>
</html>