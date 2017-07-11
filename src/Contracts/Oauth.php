<?php 
namespace Buerxiaojie\Contracts;

interface Oauth
{
	protected $authorizeAPI;

	protected $tokenAPI;

	protected $userInfoAPI;

	public function createAuthorizeAPI;

	public function createTokenAPI;

	public function getUserInfo;
}