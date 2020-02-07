<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait ListForSelectTrait
{
	public static $listForSelectFiled = 'name';

	public static function listForSelect($callback = null)
	{
		$query = self::query()->orderBy(self::$listForSelectFiled);

		if ($callback && is_callable($callback)) {
			$callback($query);
		}

		return $query->get()->pluck(self::$listForSelectFiled, 'id')->all();
	}

	public static function listForSelectWithEmpty($callback = null)
	{
		return ['' => ''] + self::listForSelect($callback);
	}

}