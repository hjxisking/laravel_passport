<?php
namespace App\Models\Passport;

use Laravel\Passport\Client as BaseClient;

class Client extends BaseClient
{
    /**
     * 确定客户端是否应跳过授权提示。
     *
     * @return bool
     */
    public function skipsAuthorization()
    {
        return true;
    }
}
