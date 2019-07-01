<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Requests\Api\Other\CommonRequest;
use App\Http\Requests\Api\UserRequest;
use App\Model\Active\User;

class UserController extends LoginController {

    public function mpLogin(CommonRequest $request) {
        $data = $this->_wxCode2Session($request->code);
        //        $data = ["session_key" => 'TKg5Edd10SeX1Po+NH2y3A==', 'openid' => 'oOR6g5uTkJKvRvo2g2kJoTzNals8'];
        $user = User::where(['openid' => $data['openid']])->first();
        if (!$user) {
            $user = User::create();
            $user->nickname = 'jhd_'.str_random(10);
            $user->remember_token = str_random(10);
            $user->openid = $data['openid'];
        }
        $user->session_key = $data['session_key'];
        $user->save();
        if (!$token = auth($this->guard)->login($user)) {
            return $this->response->error('登录失败',422);
        }

        return $this->respondWithToken($token);
    }

    public function save(UserRequest $request) {
        $user = auth($this->guard)->user();
        $user->nickName = $request->nickName;
        if($request->avatarUrl!==null) $user->avatarUrl = $request->avatarUrl;
        if($request->gender!==null) $user->gender = $request->gender;
        if($request->province!==null)  $user->province = $request->province;
        $user->save();

        return $this->response->noContent();
    }

}
