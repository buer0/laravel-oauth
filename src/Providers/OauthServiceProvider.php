<?php 
namespace Buerxiaojie\Providers;

use Illuminate\Support\ServiceProvider;

/**
* 
*/
class OauthServiceProvider extends ServiceProvider
{
	
	public function boot()
	{
		//
	}

	public function register()
	{
		$this->registerOauthSingleton();
	}

	public function registerOauthSingleton()
	{
		$this->app->singleton('', function() {
			return;
		});
	}
}