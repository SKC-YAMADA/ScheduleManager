<?php

namespace Model;

use Fuel\Core\Arr;
use fuel\core\DB;
use fuel\core\Model;
use fuel\core\Validation;
use Fuel\Core\Response;
use Myvalidations;

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

    //バリデーション------------------------------------------------------------------------------------
    public static function regi_validation($form)
    {
        // バリデーションクラスをインスタンス化
        $val = Validation::instance();

        // 拡張バリデーション
        // $val->add_callable ( new Myvalidations () );

        // バリデーション結果
        $result = false;

        // バリデーション
        $val->add('last_name', '苗字')
            ->add_rule('required')
            ->add_rule('max_length', 255);

        $val->add('first_name', '名')
            ->add_rule('required')
            ->add_rule('max_length', 255);

        $val->add('mail', 'メールアドレス')
            ->add_rule('required')
            ->add_rule('valid_email')
            ->add_rule('max_length', 255);

        $val->add('pass', 'パスワード')
            ->add_rule('required')
            ->add_rule('max_length', 255);

        $val->add('pass_ck', '確認用パスワード')
            ->add_rule('required')
            ->add_rule('max_length', 255);

        $val->add('sex', '性別')
            ->add_rule('required');

        // 何も引数を指定しなかった場合、デフォルトで$_POSTが引き渡される
        if($val->run()){
            // バリデーション成功
            $result = true;
            return $result;
        }else{
            // バリデーション失敗
            echo "<b style='color: red; font-size: 32px;'>入力に誤りがあります</b><br>";
            foreach($val->error() as $key=>$value){
                echo $value -> get_message();
                echo "<br>";
            }
            exit;
        }
    }

}