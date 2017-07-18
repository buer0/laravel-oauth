<?php 
namespace Buerxiaojie\Servers;

/**
* 
*/
class WeChat extends AbstractServer
{
	
	protected $authorizeAPI = 'https://open.weixin.qq.com/connect/oauth2/authorize?';

    protected $authorizeScope = 'snsapi_userinfo';

    protected $tokenAPI ='https://api.weixin.qq.com/sns/oauth2/access_token';

    protected $openIdAPI = 'https://api.weixin.qq.com/sns/userinfo?';

    protected $userInfoAPI = 'https://api.weixin.qq.com/sns/userinfo?';

    protected $openID;

  
    public function createAuthorizeAPI()
    {
        $params = [
            'response_type' => 'code',
            'appid' => $this->client_id,
            'redirect_uri' => $this->redirect_url,
            'state' => $this->state,
            'scope' => $this->authorizeScope
        ];

        return $this->authorizeAPI . http_build_query($params) . '#wechat_redirect';
    }

    /**
     * Get token data.
     * 
     * @param  string    $code 
     * @access public
     * @return void
     */
    public function getToken($code)
    {
		$uri = $this->createTokenAPI($code);
		$response = $this->http->get($uri);

        $body = json_decode($response->getBody()->getContents(), true);

        $this->openID = $body['openid'];
		return $body['access_token'];
    }


    public function createTokenAPI($code)
    {
        $params = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->client_id,
            'secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_url,
            'code' => $code
        ];

        return $this->tokenAPI . http_build_query($params);
    }

    /**
     * Get the open id.
     * 
     * @param  string    $token 
     * @access public
     * @return string
     */
    public function getOpenID($token)
    {
        return $this->openID;
    }


    public function getUserInfo($token, $openID)
    {
        $response = $this->http->get($this->createUserInfoAPI($token, $openID));

        $body = json_decode($response->getBody()->getContents(), true);
        return $body;
    }

    public function createUserInfoAPI($token, $openID)
    {
        $params = [
            'access_token' => $token,
            'openid' => $openID,
            'lang' => 'zh_CN'
        ];
        return $this->userInfoAPI . http_build_query($params);
    }
}