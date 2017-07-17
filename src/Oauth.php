<?php 
namespace Buerxiaojie;

use Illuminate\Support\Facades\Route;
/**
* 
*/
class Oauth
{
	
	public static function routes($callback = null, array $options = [])
	{
		$callback = $callback ?: function($router) {
			$router->registerRoute();
		};

		$defaultOptions = [
			'prefix' => 'oauth',
			'namespace' => '\Buerxiaojie\Http\Controllers'
		];
		$options = array_merge($defaultOptions, $options);

		Route::group($options, function($router) use ($callback) {
			$callback(new RouteRegistrar($router));
		});
	}
}