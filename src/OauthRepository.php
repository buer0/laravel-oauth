<?php 
namespace Buerxiaojie;

use Illuminate\Http\Request;
use Exception;

/**
* 
*/
class OauthRepository
{
	protected $servers = [
		'qq' => 'Buerxiaojie\Servers\QQ',
		'wechat' => 'Buerxiaojie\Servers\WeChat',
		'github' => 'Buerxiaojie\Servers\Github'
	];

	public $server;

	protected $current_server_name;

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

		$this->userInfo = $this->server->getUserInfo($token, $openID);

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

		$this->current_server_name = $server;
		return $this->serverInstance($server);
	}

	public function currentServerName()
	{
		return $this->current_server_name;
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