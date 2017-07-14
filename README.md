# oauth for laravel

# （一）安装

### 1. 安装：


```php
composer require buerxiaojie/laravel-oauth
```

### 2. 注册：


在 `config/app.php` 文件的 `providers` 数组中加入：

```php
  Buerxiaojie\Providers\OauthServiceProvider::class,
```


在 `config/app.php` 文件的 `aliases` 数组中加入：

```php
  'OauthUser' => Buerxiaojie\Facades\Oauth::class,
```


### 3. 生成配置文件：


```php
  php artisan vendor:publish
```


## （二）配置

在 `config/oauth.php` 文件中配置以下：

```php
  /**
   * 加入以下
   * 
   */
   
  	'qq' => [
		'app_id' => 'YOUR APP ID',
		'app_secret' => 'YOUR APP SECRET',
	],
	'wechat' => [
		'app_id' => 'YOUR APP ID',
		'app_secret' => 'YOUR APP SECRET'
	]
 
```

## （三）使用


### 1. 在QQ ，微信等平台注册账号，并将回掉地址修改为`{YOUR HOST}/oauth/oauth-callback`：


### 2. 在`app/Oauth/Hander.php`文件的`handle`方法中进行获取用户信息之后的逻辑处理：

```php
	/**
	*业务处理
	*/
	public function handle()
	{
		//$oauthUser 即为获取的用户信息
		$oauthUser = OauthUser::userInfo();

		/**
		*业务处理
		*/
	}

```

### 3. 添加新的`server`。


#### 1. 运行一下命令生成`server`类

```php
	php artisan make:oauthServer Github
```

`app/Oauth/Servers/Github.php`即可生成。填充相应的方法即可。

#### 2. 在 `config/oauth.php` 文件中配置以下：

```php
  /**
   * 加入以下
   * 
   */
   'servers' => [
		'github' => 'App\Oauth\Servers\Github',
	],
   

  'github' => [
		'app_id' => 'YOUR APP ID',
		'app_secret' => 'YOUR APP SECRET',
	]
 
```

#### 3. 在页面中放置请求链接：

```php
	<a href="/oauth/oauth-login?server=github"><img src=""></a>
```

#### 4. 若自定义回掉地址，则在对应的回掉方法中通过以下方法获取用户信息：
```php
	use OauthUser;

	public function oauthCallback(Request $request)
	{
		$userInfo = OauthUser::getUserInfo($request);

		/**
		* 其他业务逻辑
		*/
	}
```