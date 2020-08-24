<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> 予約情報入力画面 </title>
</head>

<body>

    <?php
        // option タグに部屋名を格納
        $room_list = "";
        foreach ($room_info as $key => $value) {
            $room_list .= "<option value='". $key;
            $room_list .= "'>" . $value . "</option>";
        }
    ?>

    <form method="post" action="confirm">
        <p> 会議場所 </p>
        <select name="select_room">
            <?php echo $room_list; ?>
        </select>
        <br>

        <p> 予約開始日時 </p>
        <input type="datetime-local" name="start_at">
        <br>

        <p> 予約終了日時 </p>
        <input type="datetime-local" name="end_at">
        <br>

        <p> 備考欄 </p>
<!-- このtextareaはタブしない -->
<textarea name="remarks" rows="4" cols="75" placeholder=" 何か記載する場合は入力してください "></textarea>
        <br>

        <input type="submit" name="send" value=" 送信 ">
    </form>
</body>

</html>