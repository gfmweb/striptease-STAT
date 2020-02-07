<?php


namespace App\Helpers;


use File;

class AssetsHelper
{
	const JS_SCRIPT  = '<script type="text/javascript" src="%s"></script>';
	const CSS_SCRIPT = '<link rel="stylesheet" href="%s" />';

	/** Возвращает URL с указанием времени последней правки файла (ресурса)
	 * Версия прописывается в GET параметр v
	 * @param      $url
	 * @param bool $forBlade
	 * @return string
	 */
	public static function asset($url, $forBlade = true)
	{
		$url         = trim($url, "'"); /* убирает кавычки в @asset('...') (просто $url передается с кавычками) */
		$fullUrl     = asset($url);
		$fileAddress = trim($url, "/"); /* '/js/file.js' to 'js/file.js'  */
		if ($forBlade) {
			$lastModified = file_exists($fileAddress) ? '?v=<?=File::lastModified("' . $fileAddress . '")?>' : '';
		} else {
			$lastModified = file_exists($fileAddress) ? '?v=' . File::lastModified($fileAddress) : '';
		}

		return $fullUrl . $lastModified;
	}

	/** Подключает ресурс JavaScript возвращая оформленный html-тег <script ...
	 * @param      $url
	 * @param bool $forBlade
	 * @return string
	 */
	public static function assetJs($url, $forBlade = true)
	{
		return sprintf(self::JS_SCRIPT, self::asset($url, $forBlade));
	}

	/** Подключает ресурс CSS возвращая оформленный html-тег <link ...
	 * @param      $url
	 * @param bool $forBlade
	 * @return string
	 */
	public static function assetCss($url, $forBlade = true)
	{
		return sprintf(self::CSS_SCRIPT, self::asset($url, $forBlade));
	}
}