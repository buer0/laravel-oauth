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
		$this->publishes([
			__DIR__ . '/../Handler/Handler.php' => app_path('Oauth/Handler.php'),
		]);

		if ($this->app->runningInConsole()) {

            $this->commands([
                \Buerxiaojie\Console\OauthServerCommand::class,
            ]);
        }
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