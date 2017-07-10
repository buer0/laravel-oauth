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
	}
}