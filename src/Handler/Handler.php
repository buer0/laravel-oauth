<?php 
namespace App\Oauth;

use OauthUser;
/**
* 
*/
class Handler
{
	
	public function handle()
	{
		$user = OauthUser::userInfo();
		//
	}
}