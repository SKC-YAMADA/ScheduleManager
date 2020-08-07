<?php
$path_new = Config::get('base_url');
$path_new .= "entrance/top/new";

$path_top = Config::get('base_url');
$path_top .= "entrance/top/";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> ログインページ </title>
</head>

<body>

<h1> ログインページ </h1>
<p>
    まだ登録が済んでいない方は
    <a href="<?php echo $path_new ?>"> こちら </a>からどうぞ
</p>

<form method="post" action="collation">
    <input type="email" name="mail" placeholder="メールアドレスを入れてください!">
    <input type="password" name="pass" placeholder="パスワードを入れてください!">
    <input type="submit" name="login" value=" ログイン ">
</form>

<a href="<?php echo $path_top ?>"> トップページに戻る </a>

<footer>
    <p >開発 → SKC </p>
    <p> 開発ツール → FuelPHP </p>
</footer>

</body>

</html>