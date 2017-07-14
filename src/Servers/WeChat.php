<?php 
namespace Buerxiaojie\Servers;

/**
* 
*/
class WeChat extends AbstractServer
{
	
	public $authorizeAPI = 'https://open.weixin.qq.com/connect/oauth2/authorize?';

    /**
     * The authorize scope.
     * 
     * @var string
     * @access public
     */
    public $authorizeScope = 'snsapi_userinfo';

    /**
     * The token api.
     * 
     * @var string
     * @access public
     */
    public $tokenAPI ='https://api.weixin.qq.com/sns/oauth2/access_token';

    /**
     * The open id api.
     * 
     * @var string
     * @access public
     */
    public $openIdAPI = 'https://api.weixin.qq.com/sns/userinfo?';

    /**
     * The user info api.
     * 
     * @var string
     * @access public
     */
    public $userInfoAPI = 'https://api.weixin.qq.com/sns/userinfo?';

	public $redirectURI = 'https://<Your Server>/user-oauthCallback-wechat.html';
    /** 
     * Create the api of authorize. 
     * 
     * @access public
     * @return string
     */
    public function createAuthorizeAPI()
    {
        $token= md5(uniqid(mt_rand(1,9999),1).time());
        $_SESSION['wechattoken']=$token;
        $this->redirectURI= url('/oauth/oauth-callback');
        
        $params['appid']     = $this->clientID;
        $params['redirect_uri']  = $this->redirectURI;
        $params['response_type'] = 'code';
        $params['scope']         = $this->authorizeScope;
        $params['state']         = $this->state;

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
		$token = $this->http->get($uri);

		return $token;
    }


    public function createTokenAPI($code)
    {
        $params['grant_type']    = 'authorization_code';
        $params['appid']     = $this->clientID;
        $params['secret'] = $this->clientSecret;
        $params['redirect_uri']  = $this->redirectURI;
        $params['code']          = $code;

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
        return $token->openID;
    }


    public function getUserInfo($token, $openID)
    {
        $userInfo = $this->http->get($this->createUserInfoAPI($token, $openID));
        return $userInfo;
    }

    public function createUserInfoAPI($token, $openID)
    {
    	$params['access_token']       = $token->accessToken;
        $params['openid']             = $openID;
        $params['lang']             = 'zh_CN';
        return $this->userInfoAPI . http_build_query($params);
    }
}