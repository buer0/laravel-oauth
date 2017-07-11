<?php 
namespace Buerxiaojie\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OauthUser;

/**
* 
*/
class OauthController
{
	public function oauthUri()
	{
		$oauthUri = OauthUser::oauthUri();
	}


	public function oauthLogin()
	{
		$uri = $this->oauthUri();
		return new Response('', 302, ['Location'=>$uri]);
	}


	public function oauthCallback()
	{
		//
	}
}