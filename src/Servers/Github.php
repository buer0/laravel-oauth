<?php 
namespace Buerxiaojie\Servers;

/**
* 
*/
class Github extends AbstractServer
{
	
	protected $authorizeAPI = 'https://github.com/login/oauth/authorize?';

	protected $tokenAPI ='https://github.com/login/oauth/access_token';

	protected $openIdAPI = '';

	protected $userInfoAPI = 'https://api.github.com/user?';

	protected $authorizeScope = ['user:email'];

	public function createAuthorizeAPI()
	{
		$params = [
			'client_id' => $this->client_id,
			'redirect_uri' => $this->redirect_url,
			'scope' => $authorizeScope,
			'state' => $this->state,
		];

		return $this->authorizeAPI . http_build_query($params);
	}

	public function getToken($code)
	{
		$params = [
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
			'code' => $code,
			'scope' => $this->authorizeScope
		];

		$response = $this->http->post($this->tokenAPI, [
			'headers' => ['Accept' => 'application/json'],
			'form_params' => $params]);

		return json_decode($response->getBody(), true)['access_token'];
	}

	public function getOpenID($token) {
		return $token;
	}

	public function getUserInfo($token, $openID)
	{
		$response = $this->http->get($this->createUserInfoAPI($token), [
				'headers' => ['Authorization' => 'token ' . $token]
			]);
		$userInfo = json_decode($response->getBody(), true);
		$userInfo['email'] = $this->getEmaiByToken($token);
        return $userInfo;
	}

	public function createUserInfoAPI($token)
	{
		return $this->userInfoAPI;
	}

	public function getEmaiByToken($token)
	{
		$emailsUrl = 'https://api.github.com/user/emails?access_token='.$token;
        try {
            $response = $this->http->get($emailsUrl);
        } catch (Exception $e) {
            return;
        }
        foreach (json_decode($response->getBody(), true) as $email) {
            if ($email['primary'] && $email['verified']) {
                return $email['email'];
            }
        }
	}
}