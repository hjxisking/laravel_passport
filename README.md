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

* TODO：实现第三方登录后code回跳
