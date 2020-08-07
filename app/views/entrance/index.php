<?php
$path_new = Config::get('base_url');
$path_new .= "entrance/top/new";

$path_login = Config::get('base_url');
$path_login .= "entrance/top/login";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> Hello! </title>
    
    <style>
        footer{
            padding: 0px 20px;
            color: gray;
        }
        li{
            list-style: none;
        }
    </style>
</head>

<body>

<h1> トップページへようこそ </h1>

<div>
    <h2>クイックアクセス</h2>
    <ul>
        <li>
            <b> 新規登録の方は </b>
            <a href="<?php echo $path_new ?>">こちら</a>
        </li>
        <li>
            <b> 登録済みの方は </b>
            <a href="<?php echo $path_login ?>">こちら</a>
        </li>
    </ul>
</div>

<footer>
    <p >開発 → SKC </p>
    <p> 開発ツール → FuelPHP </p>
    <p> 開発階層 → <?php echo $dir; ?> </p>
</footer>

<body>

</html>