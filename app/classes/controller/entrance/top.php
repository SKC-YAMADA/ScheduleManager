<?php

use Fuel\Core\Config;
use Fuel\Core\Arr;
use Fuel\Core\Response;
use Model\Users;
use Functions\Common;
use validate\Entrance;

/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

 class Controller_entrance_top extends Controller
 {
    public function action_index()
    {
        $dir = __DIR__;

        $data = array();
        $data["dir"] = $dir;

        $view = View::forge( "entrance/index", $data );
        return Response::forge( $view );
    }

    // 新規登録-------------------------------------------------------------------------------------------------------------
    // 入力画面
    public function action_new()
    {
        $view = View::forge( "entrance/new");
        return Response::forge( $view );
    }

    // 入力情報確認場面
    public function action_confirm()
    {
        // newメソッドのviewファイルの入力情報を配列で受け取る
        $form = Input::Post();

        // formの中身がからならばリダイレクトする
        if(!$form){
            Response::redirect("entrance/top/new");
        }

        $v_result = Users::regi_validation($form);

        // 入力情報を変数に格納する
        $last_name = $form["last_name"];
        $first_name = $form["first_name"];
        $mail = $form["mail"];
        $pass = $form["pass"];
        $pass_ck = $form["pass_ck"];
        $sex = $form["sex"];

        // 情報の送信
        $send = array(
            "last_name" => $last_name,
            "first_name" => $first_name,
            "mail" => $mail,
            "pass" => $pass,
            "pass_ck" => $pass_ck,
            "sex" => $sex,
        );

        $view = View::forge( "entrance/confirm", $send);
        return Response::forge( $view );
    }

    // 入力情報送信
    public function action_send()
    {
        // confirmメソッドのviewファイルの入力情報を配列で受け取る
        $form = Input::Post();

        // formの中身がからならばリダイレクトする
        if(!$form){
            Response::redirect("entrance/top/new");
        }

        // 入力情報を変数に格納する
        $last_name = $form["last_name"];
        $first_name = $form["first_name"];
        $mail = $form["mail"];
        $pass = $form["pass"];
        $sex = $form["sex"];

        // 情報の送信
        $send = array(
            // 入力情報
            "last_name" => $last_name,
            "first_name" => $first_name,
            "mail" => $mail,
            "pass" => $pass,
            "sex" => $sex,
        );

        Users::insert_users_info( $send );
    
        $view = View::forge( "entrance/send", $send);
        return Response::forge( $view );
    }

    //ログイン場面-------------------------------------------------------------------------------------------------------------
    public function action_login()
    {
        $view = View::forge( "entrance/login");
        return Response::forge( $view );
    }

    public function action_collation()
    {
        // 入力情報の取得
        $input = Input::Post();
        $input_mail = Arr::get($input, 'mail', null);
        
        // 入力情報をもとに抽出し持ってくる
        $users_info = Users::get_users_info( $input_mail );
        if(!empty($users_info)){
            $result = Common::login($input, $users_info);
            if($result){
                Response::redirect("internal/mypage");
            }else{
                $view = View::forge( "error/differ" );
                return Response::forge( $view );       
            }
        }else{
            $view = View::forge( "error/differ" );
            return Response::forge( $view );
        }
    }

    //接続確認-------------------------------------------------------------------------------------------------------------
    public function action_connection_check()
    {
        $all_data = Users::connection_check() -> as_array();

        var_dump($all_data);
        exit;
    }
 }