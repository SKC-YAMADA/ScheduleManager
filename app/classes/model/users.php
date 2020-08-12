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

        // POSTに空データがないか
        if(empty($form["sex"])){
            Response::redirect("entrance/top/new");
        }

        $last_name = $form["last_name"];
        $first_name = $form["first_name"];
        $mail = $form["mail"];
        $pass = $form["pass"];
        $pass_ck = $form["pass_ck"];
        $sex = $form["sex"];

        echo "<pre>";
        var_dump($form);
        echo "</pre>";

        // バリデーション
        $val->add('last_name', $last_name)
            ->add_rule('required')
            ->add_rule('max_length', 255);

        $val->add('first_name', $first_name)
            ->add_rule('required')
            ->add_rule('max_length', 255);

        $val->add('mail', $mail)
            ->add_rule('required')
            ->add_rule('valid_email')
            ->add_rule('max_length', 255);

        $val->add('pass', $pass)
            ->add_rule('required')
            ->add_rule('max_length', 255);

        $val->add('pass_ck', $pass_ck)
            ->add_rule('required')
            ->add_rule('max_length', 255);

        $val->add('sex', $sex)
            ->add_rule('required');

        // 何も引数を指定しなかった場合、デフォルトで$_POSTが引き渡される
        if($val->run()){
            $result = true;
            return $result;
        }else{
            // バリデーション失敗
            // return $result;

            foreach($val->error() as $key=>$value){
                // $key:'email'
                // $value:エラー
                // $value->get_message();
                echo $value->get_message();
            }
        }
    }

}