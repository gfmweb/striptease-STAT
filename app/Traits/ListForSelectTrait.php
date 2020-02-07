<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait ListForSelectTrait
{
	// Поле по которому сортировка по умолчанию
	public static $listForSelectOrderField = 'name';
	// Поле по которому собираются данные в массив [id => поле]
	public static $listForSelectField = 'name';

	public static function listForSelect($callback = null)
	{
		$query = self::query()->orderBy(self::$listForSelectOrderField);

		if ($callback && is_callable($callback)) {
			$callback($query);
		}

		return $query->get()->pluck(self::$listForSelectField, 'id')->all();
	}

	public static function listForSelectWithEmpty($callback = null)
	{
		return ['' => ''] + self::listForSelect($callback);
	}

}