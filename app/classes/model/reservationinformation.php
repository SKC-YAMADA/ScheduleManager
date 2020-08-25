<?php

namespace Model;

use Console;
use Fuel\Core\Arr;
use Fuel\core\DB;
use Fuel\core\Model;
use fuel\core\Validation;
use DateTime;

class ReservationInformation extends \Orm\Model
{
    protected static $_table_name = 'reservation_information';
	protected static $_primary_key = array('reservation_information_id');

	protected static $_properties = array(
		'reservation_information_id',
		'room_information_id',
        'user_id',
		'request_status',
		'start_at',
		'end_at',
		'reservation_at',
		'remarks',
		'updated_at',
		'created_at',
		'del_flg',
    );

    /* TODO:1 save_event_info()を参考にしてCRUDを使用した処理を確認する
              reservartion()とsave_event_info()は似たような役目をしている
       TODO:2 バリデーションチェック処理を追加
              ・会議室保存処理時に会議室の空きがあるかどうかを確認し、その結果を返す関数を作成
              ・バリデーションメッセージを受け取りviewに表示する
              ※ajaxを使用しているのでjsのalertでメッセージが表示できると楽かも
       TODO:3 room_information_idをcontroller側で取得し、model.reservationinformationに渡して保存する
       TODO:4 user_idをcontroller側で取得し、model.reservationinformationに渡して保存する
    */ 
    public static function reservation($regi_data)
    {
        $values = array();

        // フォームの入力情報取得
        $mail        = Arr::get($regi_data, 'mail');
        $pass        = Arr::get($regi_data, 'pass');
        $last_name   = Arr::get($regi_data, 'last_name');
        $first_name  = Arr::get($regi_data, 'first_name');
        $sex         = Arr::get($regi_data, 'sex');

        // $valuesに入力情報を格納
        $values['mail']          = $mail;
        $values['pass']          = $pass;
        $values['last_name']     = $last_name;
        $values['first_name']    = $first_name;
        $values['sex']           = $sex;
        $values['created_at']    = date("Y/m/d H:i:s");
        $values['updated_at']    = date("Y/m/d H:i:s");
        $values['del_flg']       = 0;

        // インスタンス化
        $users = Users::forge($values);
        // insertする
        $users -> save();
    }

    /***
     * スケジュール情報を取得する
     */
    public static function get_event_info($data){

        $where = '';
        $reservation_information_id = Arr::get($data, 'event_id');
        $user_id                    = Arr::get($data, 'user_id');

        if(!empty($reservation_information_id)){
            $where .= " AND reservation_information_id = $reservation_information_id";
        }

        if(!empty($user_id)){
            $where .= " AND user_id = $user_id";
        }

        // 削除フラグが0で、リクエストステータスが1のものを取得
        $sql = "
            SELECT
                 *
            FROM 
                 reservation_information
            WHERE
                 del_flg = 0
                 AND request_status = 1
                 $where
        ";
        $result = \DB::query($sql)->execute()->as_array();
        return $result;
    }

    /**
     * スケジュールを作成、更新、削除して結果を返す
     */
    public function save_event_info($data){
        $result = 0;
        $exist_event_info = self::get_event_info($data);
        $insert_value = self::shape_event_info($data);
        $validation_result = self::save_event_check($insert_value);
        if(empty($exist_event_info)){
            // スケジュールIDがない場合は新規登録とする
            $event_info = $this->forge($insert_value);
            $event_info -> save();
            $result = $event_info->reservation_information_id;
        }else{
            if($data['type'] === 'delete'){
                $event_info = self::forge();
                $event_info = self::find($data['event_id']);
                $event_info->del_flg = 1;
                $event_info->request_status = 0;
                $event_info -> save();
            }else{
                // 既にスケジュールIDが存在した場合は更新する
                $event_info = self::forge();
                $event_info = self::find($data['event_id']);
                $event_info = $event_info->set($insert_value);
                $event_info -> save();
                $result = $event_info['reservation_information_id'];
            }
        }
        return $result;
    }

    /***
     * スケジュールを整形する
     */
    private static function shape_event_info($data){
        $event_info          = Arr::get($data,'event_info');
        $room_information_id = 2; // TODO:3:room_information_idを取得してセットする
        $user_id             = Arr::get($data,'user_id');
        $request_status      = 1;
        $start_at            = Arr::get($event_info,'start_date');
        $end_at              = Arr::get($event_info,'end_date');
        $reservation_at      = Arr::get($data,'is_new');
        $remarks             = Arr::get($event_info,'text');
        $user_id             = 8; // TODO:4:user_idを取得してセットする
        $start_at            = self::conversion_insert_date_time($start_at);
        $end_at              = self::conversion_insert_date_time($end_at);
        $reservation_at      = date('Y-m-d H:i:s');

        $insert_value = array(
            'room_information_id' => $room_information_id,
            'user_id'            => $user_id,
            'request_status'     => $request_status,
            'start_at'           => $start_at,
            'end_at'             => $end_at,
            'reservation_at'     => $reservation_at,
            'remarks'            => $remarks,
            'del_flg'            => 0,
        );

        return $insert_value;
    }

    /**
     * view側で受け取った時刻のフォーマットを変更する
     */
	public static function conversion_insert_date_time($target_date_time)
	{
        $target_date_time =  strtotime(mb_substr($target_date_time,0,24));
        return date('Y-m-d H:i:s',$target_date_time);
    }

    // バリデーション------------------------------------------------------------------------------------------
    public static function save_event_check($data)
    {
        $val = Validation::forge();
        $today = date("Y/m/d H:i:s");
        $result = false;

        $val->add('user_id', 'ユーザーIDの取得')
            ->add_rule('required');

        $val->add('request_status', '登録状態')
            ->add_rule('required');

        $val->add('start_at', '予約開始日時')
            ->add_rule('required')
            ->add_rule('valid_date', 'Y-m-d H:i:s');

        $val->add('end_at', '予約終了日時')
            ->add_rule('required')
            ->add_rule('valid_date', 'Y-m-d H:i:s');

        $val->add('reservation_at', '予約した時間')
            ->add_rule('required');

        if($val->run($data)){
            // バリデーション成功
            $result = true;
            return $result;
        }else{
            // バリデーション失敗
            echo "<b style='color: red; font-size: 32px;'>予約に失敗しました</b><br>";
            echo "<p> 以下の項目をチェックしてください</p>";
            echo "<ol>";
            echo "<li> 入力情報の誤り </li>";
            echo "<li> 不正な日付の入力 </li>";
            echo "<li> 許容文字数の超過 </li>";
            echo "<li> すでに登録済みの予定がある </li>";
            echo "</ol>";
            foreach($val->error() as $key=>$value){
                echo $value -> get_message();
                echo "<br>";
            }
            exit;
        }
    }
}