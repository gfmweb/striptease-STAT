<?php


namespace App\Helpers;


class TextHelper
{
	/**
	 * @param     $num
	 * @param int $dec
	 * @return string
	 */
	public static function numberFormat($num, $dec = 0)
	{
		return $num ? number_format($num, $dec, ',', ' ') : '0';
	}
}