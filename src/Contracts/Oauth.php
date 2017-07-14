<?php 
namespace Buerxiaojie\Contracts;

interface Oauth
{
	public function createAuthorizeAPI;

	public function getToken;

	public function getOpenID;

	public function getUserInfo;
}