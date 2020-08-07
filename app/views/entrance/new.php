<?php
$path_top = Config::get('base_url');
$path_top .= "entrance/top/";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> 会員登録ページ </title>
    
    <style>
        footer{
            padding: 0px 20px;
            color: gray;
        }
    </style>
</head>

<body>

<div>
    <h1> 会員登録ページ </h1>
    <form method="post" action="confirm">
        <input type="text" name="last_name" size="25" placeholder="姓を入れてください">
        <input type="text" name="first_name" size="25" placeholder="名を入れてください">
        <br>
        <input type="email" name="mail" size="50" placeholder="メールアドレスを入力してください">
        <br>
        <input type="password" name="pass" size="50" placeholder="パスワードを入力してください">
        <br>
        <input type="password" name="pass_ck" size="50" placeholder="確認のため、もう一度お願いします">
        <br>
            男性 ➡ <input type="radio" name="sex" value="1">
            女性 ➡ <input type="radio" name="sex" value="0">
        <br>
        <input type="submit" name="send" value=" 確認 ">
    </form>
</div>

<a href="<?php echo $path_top; ?>"> トップページに戻る </a>

<footer>
    <p >開発 → SKC </p>
    <p> 開発ツール → FuelPHP </p>
</footer>

<body>

</html>