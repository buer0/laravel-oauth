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
		return OauthUser::oauthUri();
	}


	public function oauthLogin()
	{
		$uri = $this->oauthUri();
		return new Response('', 302, ['Location'=>$uri]);
	}


	public function oauthCallback(Request $request)
	{
		$code = $request->get('code');
		if(!$code) {
			return json_encode(['error' => 'param error']);
		}

		$token = OauthUser::getToken($code);

		$openID = OauthUser::getOpenID($token);

		$userInfo = OauthUser::getUserInfo($openID);
	}
}