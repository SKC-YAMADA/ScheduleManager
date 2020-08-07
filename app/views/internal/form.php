<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> 入力しろ </title>
</head>

<body>

    <?php
        $room_list = "";
        foreach ($room_info as $key => $value) {
            $room_list .= "<option value='". $key;
            $room_list .= "'>". $value. "</option>";
        }
        echo $room_list;
    ?>

    <form method="post" action="confirm">
        <p> 会議場所 </p>
        <select name="select" value="not_selected">
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