<?php 
namespace Buerxiaojie\Servers;

use Buerxiaojie\Contracts\Oauth;

abstract class  AbstractServer implements Oauth
{
	protected $authorizeAPI;

	protected $tokenAPI;

	protected $userInfoAPI;

	abstract public function createAuthorizeAPI;

	abstract public function createTokenAPI;

	abstract public function getUserInfo;
}