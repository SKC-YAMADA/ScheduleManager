<?php

use Fuel\Core\Config;
use Fuel\Core\Arr;
use Fuel\Core\Response;
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
    public function action_index()
    {
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
        $input       = Input::Post();
        $start_at    = Arr::get($input, 'start_at', NULL);
        $end_at      = Arr::get($input, 'end_at', NULL);
        $remarks     = Arr::get($input, 'remarks', NULL);

        $regi_data = array(
            'room_information_id' => 2,
            'user_id' => 1,
            'request_status' => 1,
            'start_at' => $start_at,
            'end_at' =>  $end_at,
            'reservation_at' => '2000-01-31 07:00:00',
            'remarks' => $remarks,
        );

        $view = View::forge( "internal/confirm", $regi_data);
        return Response::forge($view);
    }

 }