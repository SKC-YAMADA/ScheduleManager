<?php

namespace Model;

use Fuel\Core\Arr;
use fuel\core\DB;
use fuel\core\Model;

class Areainformationmaster extends Model
{
    public static function get_place_info()
    {
        $sql = "
        SELECT
            *, concat(aim.area_name, rim.room_name) as full_name
        FROM
            area_information_master as aim
            inner join room_information_master as rim
            on aim.area_id = rim.area_id
        WHERE
            aim.del_flg = 0 AND rim.del_flg = 0
        ORDER BY
            full_name ASC
        ;";

        $result = DB::query( $sql ) -> execute();
        return $result;
    }
}