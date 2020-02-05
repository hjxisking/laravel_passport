基于laravel-passport
测试学习用

* 创建客户端ID，创建的时候不要输入user ID
```
php artisan passport::client
```

* get访问oauth/authorize来获取code，如果没登录，则跳转到来登录界面，完成登录后带着code访问redirect_url
```
http://passport.test/oauth/authorize?client_id=3&redirect_uri=http://larabbs.test/auth/callback&response_type=code&scope
```

* 在redirect_uri中用code换取accessToken，并自行产生session
```
$response = $http->post('http://your-app.com/oauth/token', [
    'form_params' => [
        'grant_type' => 'authorization_code',
        'client_id' => 'client-id',
        'client_secret' => 'client-secret',
        'redirect_uri' => 'http://example.com/callback',
        'code' => $request->code,
    ],
]);
```

* 第三方登录后code回跳，具体跳转方式可以参考微信的，这里描述的是回来如何处理
    - 一般第三饭都是基于OAuth2的模式，回跳回来会有一个code，然后通过code换取access token，通过access token换取用户信息，接下来可以仿照用户登录的控制器，实现登录并跳转redirect_uri
    ```
        public function fakeLogin(Request $request) {
            // 第三方OAuth获取用户信息后，如果用户不存在则新建一个，如果已经存在则找到这个用户，调用守护器的login方法，并response
            $user = User::find(1);
            Auth::guard()->login($user);
            return $this->sendLoginResponse($request);
        }
    ```
    - 测试方式
        - 访问http://passport.test/oauth/authorize?client_id=3&response_type=code&scope=*&state=myparam，会引导登录界面
        - 修改浏览器里的登录地址为：http://passport.test/fakeLogin 实现自动登录（模拟第三方OAuth已经回跳并创建或者验证user的过程）
        - 自动引导回http://passport.test/oauth/authorize?client_id=3&response_type=code&scope=*&state=myparam，这时候用户已经登录，所以会跳转到数据库里设定好到redirect_uri，并带着state自定义参数
        
