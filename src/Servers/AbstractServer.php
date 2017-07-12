<?php 
namespace Buerxiaojie\Servers;

use Buerxiaojie\Contracts\Oauth;
use GuzzleHttp\Client;

abstract class  AbstractServer implements Oauth
{
	protected $authorizeAPI;

	protected $tokenAPI;

	protected $userInfoAPI;

	protected $http;

	protected $state;

	public function __construct()
	{
		$this->http = new Client();
		$this->state = 'state';
	}

	abstract public function createAuthorizeAPI;

	abstract public function createTokenAPI;

	abstract public function getUserInfo;
}