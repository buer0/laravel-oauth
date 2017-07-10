<?php 
namespace Buerxiaojie;

use Illuminate\Contracts\Routing\Registrar as Router;

/**
* 
*/
class RouteRegistrar
{
	
	protected $router;

	public function __construct(Router $router)
	{
		$this->router = $router;
	}

	public function all()
	{
		$this->oauthUri();
		$this->oauthLogin();
		$this->oauthCallback();
	}

	public function oauthUri()
	{
		$this->router->get('oauth-uri', ['uses'=>'OauthController@oauthUri']);
	}

	public function oauthLogin()
	{
		$this->router->get('oauth-login', ['middleware'=>'web', 'uses'=>'OauthController@oauthLogin']);
	}

	public function oauthCallback()
	{
		$this->router->get('oauth-callback', ['middleware'=>'web', 'uses'=>'OauthController@oauthCallback']);
	}
}