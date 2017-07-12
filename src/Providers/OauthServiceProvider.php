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
		$this->publishes([
			__DIR__ . '/../Config/OauthConfig.php' => config_path('oauth.php'),
		]);
		/*
			发布用户信息处理类
		*/
	}

	public function register()
	{
		$this->registerOauthSingleton();
	}

	public function registerOauthSingleton()
	{
		$this->app->singleton('OauthUser', function() {
			return new OauthRepository();
		});
	}
}