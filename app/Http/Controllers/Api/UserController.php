<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    function userInfo (Request $request) {
        $user = $request->user();
        return new UserResource($user);
    }
}
