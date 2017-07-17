<?php 
namespace Buerxiaojie\Servers;

use GuzzleHttp\Client;

abstract class  AbstractServer
{
	protected $http;

	protected $state;

	protected $client_id;

	protected $client_secret;

	protected $redirect_url;

	public function __construct($server)
	{
		$this->http = new Client();
		$this->state = 'state';

		$this->client_id = config("oauth.pass.{$server}.app_id");
		$this->client_secret = config("oauth.pass.{$server}.app_secret");
		$this->redirect_url = config("oauth.pass.{$server}.redirect_url")?:url('/oauth/oauth-callback');
	}

	abstract public function createAuthorizeAPI();

	abstract public function getToken($code);

	abstract public function getOpenID($token);

	abstract public function getUserInfo($token, $openID);
}