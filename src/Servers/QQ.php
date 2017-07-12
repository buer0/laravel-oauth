<?php 
namespace Buerxiaojie\Servers;

/**
* 
*/
class QQ extends AbstractServer
{
	
	protected $authorizeAPI = 'https://graph.qq.com/oauth2.0/authorize?';

	protected $tokenAPI ='https://graph.qq.com/oauth2.0/token?';

	protected $openIdAPI = 'https://graph.qq.com/oauth2.0/me?';

	protected $userInfoAPI = 'https://graph.qq.com/user/get_user_info?';

	protected $authorizeScope = 'get_user_info';

	public function createAuthorizeAPI()
    {
    	$params = [
    		'response_type' => 'code',
    		'client_id' => config('oauth.pass.qq.app_id'),
    	];
        /*$params['response_type'] = 'code';
        $params['client_id']     = $this->clientID;
        $params['redirect_uri']  = url('/oauth/oauth-callback');
        $params['state']         = $this->state;
        $params['scope']         = $this->authorizeScope;*/

        return $this->authorizeAPI . http_build_query($params);
    }

    public function getToken($code)
    {
        $token = $this->client->get($this->createTokenAPI($token));

        return $token;
    }

    protected function createTokenAPI($code)
    {
        $params['grant_type']    = 'authorization_code';
        $params['client_id']     = $this->clientID;
        $params['client_secret'] = $this->clientSecret;
        $params['redirect_uri']  = $this->redirectURI;
        $params['code']          = $code;

        return $this->tokenAPI . http_build_query($params);
    }

    public function getOpenID($token)
    {
        $openID = $this->http->get($this->createOpenIDAPI($token));

        return $openID;
    }

    protected function createOpenIDAPI($token)
    {
        return $this->openIdAPI . "access_token=$token";
    }

    public function getUserInfo($openID)
    {
        $userInfo = $this->http->get($this->createUserInfoAPI($token, $openID));
        return $userInfo;
    }

    public function createUserInfoAPI($token, $openID)
    {
        $params['oauth_consumer_key'] = $this->clientID;
        $params['access_token']       = $token;
        $params['openid']             = $openID;
        $params['format']             = 'json';

        return $this->userInfoAPI . http_build_query($params);
    }
}