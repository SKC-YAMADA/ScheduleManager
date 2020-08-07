<?php
$path_top = Config::get('base_url');
$path_top .= "entrance/top/";

$path_login = Config::get('base_url');
$path_login .= "entrance/top/login";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> 情報送信完了場面 </title>
</head>

<body>

<h1> 送信完了! </h1>
<p> 登録ありがとうございます!! </p>

<p>
    <a href="<?php echo $path_top; ?>"> トップページに戻る </a>
</p>

<p>
    <a href="<?php echo $path_login; ?>"> ログインに飛ぶ </a>
</p>

</body>

</html>