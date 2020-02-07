<?php


namespace App\Helpers;


class CalcHelper
{
	/**
	 * @param $count
	 * @param $cost
	 * @return float|int
	 */
	public static function cpl($count, $cost)
	{
		return $count != 0 ? $cost / $count : 0;
	}

	public static function percent($current, $total)
	{
		return $total != 0 ? $current / $total * 100 : 0;
	}
}