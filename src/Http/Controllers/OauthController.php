<?php 
namespace Buerxiaojie\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OauthUser;
use App\Oauth\Handler;

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
		$userInfo = OauthUser::getUserInfo($request);

		return new Handler()->handle();
	}
}