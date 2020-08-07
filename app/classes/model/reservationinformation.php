<?php

namespace Model;

use Fuel\Core\Arr;
use fuel\core\DB;
use fuel\core\Model;

class Reservationinformation extends Model
{
    public static function reservartion($regi_data)
    {
        $room_information_id = Arr::get($regi_data, 'room_information_id', 0);
        $user_id             = Arr::get($regi_data, 'user_id', 0);
        $request_status      = Arr::get($regi_data, 'request_status', 0);
        $start_at            = Arr::get($regi_data, 'start_at', NULL);
        $end_at              = Arr::get($regi_data, 'end_at', NULL);
        $reservation_at      = Arr::get($regi_data, 'reservation_at', NULL);
        $remarks             = Arr::get($regi_data, 'remarks', NULL);

        $sql = "INSERT INTO
            reservation_information(
                `room_information_id`,
                `user_id`,
                `request_status`,
                `start_at`,
                `end_at`,
                `reservation_at`,
                `remarks`,
                `del_flg`
            )
            VALUES(
                $room_information_id,
                $user_id,
                $request_status,
                '$start_at',
                '$end_at',
                '$reservation_at',
                '$remarks',
                0
            )
        ";

        $result = DB::query( $sql ) -> execute();
        return $result;
    }
}