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
    		'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_url,
            'state' => $this->state,
            'scope' => $this->authorizeScope
    	];

        return $this->authorizeAPI . http_build_query($params);
    }

    public function getToken($code)
    {
        $token = $this->client->get($this->createTokenAPI($token));

        return $token;
    }

    protected function createTokenAPI($code)
    {
        $params = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_url,
            'code' => $code
        ];

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

    public function getUserInfo($token, $openID)
    {
        $userInfo = $this->http->get($this->createUserInfoAPI($token, $openID));
        return $userInfo;
    }

    public function createUserInfoAPI($token, $openID)
    {
        $params = [
            'oauth_consumer_key' => $this->client_id,
            'access_token' => $token,
            'openid' => $openID,
            'format' => 'json'
        ];

        return $this->userInfoAPI . http_build_query($params);
    }
}