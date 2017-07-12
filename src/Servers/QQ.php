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
        $params['response_type'] = 'code';
        $params['client_id']     = $this->clientID;
        $params['redirect_uri']  = url('/oauth/oauth-callback');
        $params['state']         = $this->state;
        $params['scope']         = $this->authorizeScope;

        return $this->authorizeAPI . http_build_query($params);
    }
}