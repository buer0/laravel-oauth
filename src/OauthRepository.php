<?php 
namespace Buerxiaojie;

use Illuminate\Http\Request;
use Exception;
use Buerxiaojie\Servers\QQ;
use Buerxiaojie\Servers\WeChat;
use Buerxiaojie\Servers\Github;


/**
* 
*/
class OauthRepository
{
	protected $servers = [
		'qq' => 'QQ',
		'wechat' => 'WeChat',
		'github' => 'Github'
	];

	public $server;

	public $userInfo;
	
	public function __construct()
	{
		$request = Request();
		$this->complateServers();
		$this->userInfo = $this->bindUserInfo($request);
		$this->server = $this->bindOauthServer($request);
	}

	public function userInfo()
	{
		return $this->userInfo;
	}

	public function oauthUri()
	{
		return $this->server->createAuthorizeAPI();
	}

	public function getUserInfo($request)
	{
		$token = $this->server->getToken($request->get('code'));

		$openID = $this->server->getOpenID($token);

		$userInfo = $this->server->getUserInfo($token, $openID);

		$this->userInfo = json_decode($userInfo);

		$request->session()->put('oauthUser', $this->userInfo);
		return $this->userInfo;
	}

	public function bindUserInfo($request)
	{
		return $request->session()->get('oauthUser') ?: null;
	}

	public function bindOauthServer($request)
	{
		$server = $request->get('server', '');
		if(!$server || !$this->validateServer($server)) {
			$server = $request->session()->pull('oauthServer');
			if(!$server || !$this->validateServer($server)) {
				throw new Exception("no oauth server in session", 1);
			}
		}else {
			$request->session()->put('oauthServer', $server);
		}

		return $this->serverInstance($server);
	}

	public function validateServer($server)
	{
		return array_key_exists($server, $this->servers);
	}

	public function serverInstance($server)
	{
		$class = $this->servers[$server];
		return new $class($server);
	}

	public function complateServers()
	{
		$configServers = config('oauth.servers');
		$this->servers = array_merge($this->servers, $configServers);
	}
}