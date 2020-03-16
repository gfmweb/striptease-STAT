<?php


namespace App\Helpers;


class CalcHelper
{
	/**
	 * стоимость за лида
	 * @param $count
	 * @param $cost
	 * @return float|int
	 */
	public static function cpl($count, $cost)
	{
		return $count != 0 ? $cost / $count : 0;
	}

	// считает процент $current к $total
	public static function percent($current, $total)
	{
		return $total != 0 ? $current / $total * 100 : 0;
	}

	// суммирует значения многомерного массива по ключам
	public static function sumValues(array $input) {
		if (is_array($input)) {
			$sums = [];
			array_walk_recursive($input, function($item, $key) use (&$sums){
			    $sums[$key] = isset($sums[$key]) ?  $item + $sums[$key] : $item;
			});
			return $sums;
		} else return false;
	}
}