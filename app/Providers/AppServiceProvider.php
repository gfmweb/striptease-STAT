<?php

namespace App\Providers;

use App\Helpers\AssetsHelper;
use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Blade::directive('asset', function ($url) {
			return AssetsHelper::asset($url);
		});

		Blade::directive('js', function ($url) {
			return AssetsHelper::assetJs($url);
		});

		Blade::directive('css', function ($url) {
			return AssetsHelper::assetCss($url);
		});
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
