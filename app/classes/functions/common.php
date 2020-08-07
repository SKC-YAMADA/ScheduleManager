<?php

namespace Functions;

use Fuel\Core\Response;
use Model\Users;
use Fuel\Core\Arr;

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

class Common{

    public static function login($input, $users_info){
        // 入力情報
        $input_mail = Arr::get($input, 'mail', null);
        $input_pass = Arr::get($input, 'pass', null);
        // テーブル情報
        $get_mail = $users_info["mail"];
        $get_pass = $users_info["password"];
        
        // 照合
        $result = FALSE;
        if($input_pass == $get_pass && $input_mail == $get_mail){
            $result = TRUE;
        }
        
        return $result;
    }
}