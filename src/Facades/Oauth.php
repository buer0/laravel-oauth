<?php 
namespace Buerxiaojie\Facades;

use Illuminate\Support\Facades\Facade;

/**
* 
*/
class Oauth extends Facade
{
	
	protected static function getFacadeAccessor()
    {
        return 'OauthUser';
    }
}