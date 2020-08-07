<?php

namespace Model;

use Fuel\Core\Arr;
use fuel\core\DB;
use fuel\core\Model;

class Users extends Model
{
    protected static $_table_name = "users";
    protected static $_primary_key = array("users_id");
    protected static $_propaties = array(
        // 新規登録時に使うもの
        'users_id',
        'mail',
        'pass',
        'pass_ck',
        'last_name',
        'first_name',
        'sex',
        'created_at',
        'update_at',
        'del_flg',
    );

    public static function connection_check()
    {
        $sql = "SELECT * FROM users";

        $result = DB::query( $sql ) -> execute();
        return $result;
    }

    public static function insert_users_info(array $send)
    {
        $mail        = Arr::get($send, 'mail', null);
        $pass        = Arr::get($send, 'pass', null);
        $last_name   = Arr::get($send, 'last_name', null);
        $first_name  = Arr::get($send, 'first_name', null);
        $sex         = Arr::get($send, 'sex', null);

        $sql = "INSERT INTO
            users(
                `mail`,
                `password`,
                `last_name`,
                `first_name`,
                `sex`
            )
            VALUES(
                '$mail',
                '$pass',
                '$last_name',
                '$first_name',
                $sex
            )";
        
        $result = DB::query( $sql ) -> execute();
        return $result;
    }
    
    public static function get_users_info($input_mail = NULL)
    {
        $sql = "SELECT * FROM users WHERE mail = '$input_mail' AND del_flg = 0";

        // current()は先頭のものを持ってくる
        $result = DB::query($sql) -> execute() -> current();
        return $result;
    }

}