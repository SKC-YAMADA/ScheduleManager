<?php

use Fuel\Core\Config;
use Fuel\Core\Arr;
use Fuel\Core\Response;
use Model\Users;
use Functions\Common;

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

namespace Validate;

class Myvalidations
{
    /**
     * 全角文字チェック
     *
     * @param string $val 判定対象の文字列
     * @return boolean 全て全角文字ならtrueを、それ以外ならfalseを返却する
     */
    public static function _validation_zenkaku($val) {
        // 半角文字を全角に変換
        $zenkaku = mb_convert_kana($val, 'AKV');

        // 変換前と同じなら全て全角文字
        return ($val === $zenkaku);
    }
}