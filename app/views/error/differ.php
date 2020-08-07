<?php
$path_top = Config::get('base_url');
$path_top .= "entrance/top/";
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title> DIFFER </title>
</head>

<body>
    <h1 style="color: red;"> タイプミスエラー </h1>
    <p> メールアドレス、パスワードの打ち間違いはありませんか? </p>
    <p> お手数ですが、もう一度入力しなおしてください。 </p>
    <p> それでもこの場面が表示されている場合は、アカウントが登録されていない可能性があります。 </p>
    <a href="<?php echo $path_top; ?>">
</body>

</html>