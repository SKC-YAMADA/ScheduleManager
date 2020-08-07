<?php
$path_top = Config::get('base_url');
$path_top .= "entrance/top/";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> 入力情報確認場面 </title>

    <style>
        footer{
            padding: 0px 20px;
            color: gray;
        }
        table, th, td{
            border: 2px solid black;
        }
        th, td{
            padding: 20px;
        }
        th{
            background-color: lavender;
        }
        td{
            background-color: aliceblue;
        }
    </style>
</head>

<body>

<div>
    <h1> 以下の内容で登録します </h1>
    
    <form method="post" action="send">
        <table border="1">
            <tr>
                <th> 姓 </th>
                <input type="hidden" name="last_name" value="<?php echo $last_name; ?>">
                <td> <?php echo $last_name; ?> </td>
            </tr>
            <tr>
                <th> 名 </th>
                <input type="hidden" name="first_name" value="<?php echo $first_name; ?>">
                <td> <?php echo $first_name; ?> </td>
            </tr>
            <tr>
                <th> メールアドレス </th>
                <input type="hidden" name="mail" value="<?php echo $mail; ?>">
                <td> <?php echo $mail; ?> </td>
            </tr>
            <tr>
                <th> パスワード </th>
                <input type="hidden" name="pass" value="<?php echo $pass; ?>">
                <td> <?php echo $pass; ?> </td>
            </tr>
            <tr>
                <th> 性別 </th>
                <input type="hidden" name="sex" value="<?php echo $sex ?>">
                <td>
                    <?php
                    if( $sex == 1 ){
                        echo "男性";
                    }else{
                        echo "女性";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="2"> <input type="submit" name="send" value=" 登録 "> </th>
            </tr>

        </table>
    </form>

</div>

<a href="<?php echo $path_top ?>"> トップページに戻る </a>

</body>

</html>