<?php

use Fuel\Core\Config;
use Fuel\Core\Arr;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Functions\Common;

use Model\Areainformationmaster;
use Model\Reservationinformation;
use Model\Roominformationmaster;
use Model\Users;

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

 class Controller_internal_mypage extends Controller
 {
    // public function before()
    // {
    //     $user_id = Session::get('user_id', '受け取れませんでした');
    //     var_dump($user_id);
    //     exit;
    //     if(!isset($user_id)){
    //         Response::redirect("entrance/top/");
    //     }
    // }

    public function action_index()
    {
        $user_id = Session::get();
        var_dump($user_id);
        exit;
        if(!isset($user_id)){
            Response::redirect("entrance/top/");
        }
        $view = View::forge( "internal/mypage");
        return Response::forge($view);
    }

    public function action_form()
    {
        // SQLを実行して情報取得
        $get_place_info = Areainformationmaster::get_place_info() -> as_array();
        
        $tmp_room_info = array();
        $room_info = array();
        foreach ($get_place_info as $key => $value)
        {
            $tmp_room_info = array(
                $value['room_information_id'] => $value['full_name']
            );
            $room_info = $room_info + $tmp_room_info;
        }

        $data = array(
            'room_info' => $room_info,
        );
        
        $view = View::forge("internal/form", $data);
        return Response::forge($view);
    }

    public function action_confirm()
    {
        $input               = Input::Post();
        $room_information_id = Arr::get($input, 'select_room', NULL);
        $start_at            = Arr::get($input, 'start_at', NULL);
        $end_at              = Arr::get($input, 'end_at', NULL);
        $remarks             = Arr::get($input, 'remarks', NULL);

        $regi_data = array(
            'room_information_id' => $room_information_id,
            'user_id' => 1,
            'request_status' => 1,
            'start_at' => $start_at,
            'end_at' =>  $end_at,
            'remarks' => $remarks,
        );

        $view = View::forge( "internal/confirm", $regi_data);
        return Response::forge($view);
    }

    public function action_sample()
    {
        // SQLを実行して情報取得
        $get_place_info = Areainformationmaster::get_place_info() -> as_array();

        $tmp_room_info = array();
        $room_info = array();
        foreach ($get_place_info as $key => $value)
        {
            $tmp_room_info = array(
                $value['room_information_id'] => $value['full_name']
            );
            $room_info = $room_info + $tmp_room_info;
        }

        $data = array(
            'room_info' => $room_info,
        );

        $view = View::forge( "internal/sample", $data);
        return Response::forge($view);
    }

    public function action_loadschedule()
    {			
        $post = Input::post();
        $data = array();
        $data['user_id'] = $post['user_id'];
		$reservation_information = new ReservationInformation(); 
		$schedules = $reservation_information->get_event_info($data);
		$tmp_schedule = array();
		$view_schedules = array();
		foreach ($schedules as $key => $schedule) {
			$tmp_schedule = array(
				'id' => $schedule['reservation_information_id'],
				'start_at' => $schedule['start_at'],
				'end_at' => $schedule['end_at'],
				'text' => $schedule['remarks'],
			);
			array_push($view_schedules, $tmp_schedule);
		}
        return json_encode($view_schedules);
    }

    public function action_save()
	{
        $result = 0;

		try{
			$server = Input::server();
			// ajax通信以外は終了
			if(strtolower(Arr::get($server, 'HTTP_X_REQUESTED_WITH', null)) == 'xmlhttprequest'){
				$post = Input::post();
				$reservation_information = new ReservationInformation(); 
				$result = $reservation_information -> save_event_info($post);
			}
		}catch(Exception $e){
		}
		return $result;
    }
    
    public function action_init()
    {
        // SQLを実行して情報取得
        $get_place_info = Areainformationmaster::get_place_info() -> as_array();
        return json_encode($get_place_info);
    }
}