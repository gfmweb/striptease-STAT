<?php


namespace App\Helpers;


use App\Password;
use App\SubProject;
use Illuminate\Database\Eloquent\Model;

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


	/**
	 * @param Model | SubProject | Password $model
	 * @return array
	 */
	public static function tagsForLabel(Model $model)
	{
		$tags = [];
		foreach ($model->tags as $tag) {
			$tags[] = [
				'name'  => $tag->name,
				'class' => 'badge-warning',
				'short' => substr($tag->name, 0, 2),
			];
		}

		return $tags;
	}
}