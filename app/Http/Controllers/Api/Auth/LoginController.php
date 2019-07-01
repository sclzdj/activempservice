<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Api\Transformers\UserTransformer;

class LoginController extends BaseController {

    protected $guard = 'users';

    public function __construct() {
        // 排除需要验证
        $this->middleware('jwt.auth:'.$this->guard, ['except' => ['login','mpLogin']]);
    }

    /**
     * 响应token
     *
     * @param $token
     *
     * @return mixed
     */
    protected function respondWithToken($token) {
        return $this->responseParseArray([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth($this->guard)->factory()->getTTL() * 60,
          ]
        );
    }

    /**
     * 登录
     * @Versions({"v1"})
     * @Post("/bs/login/admin")
     * @Request(contentType="application/json")
     * @Parameters({
     *      @Parameter("username",type="string",required=true,description="账号"),
     *      @Parameter("password",type="string",required=true,description="密码")
     * })
     * @Response(200,body=null)
     */
    public function login() {
        $request = request(['username', 'password']);
        if (!isset($request['username']) || $request['username'] === '' || $request['username'] === null) {
            return $this->response->error('请输入帐号',422);
        }
        if (!isset($request['password']) || $request['password'] === '' || $request['username'] === null) {
            return $this->response->error('请输入密码',422);
        }
        if (!$token = auth($this->guard)->attempt($request)) {
            return $this->response->error('帐号或密码错误',422);
        }

        return $this->respondWithToken($token);
    }

    /**
     * 退出
     * @Versions({"v1"})
     * @Get("/bs/logout/admin")
     * @Request(contentType="application/json")
     * @Response(204,body=null)
     */
    public function logout() {
        auth($this->guard)->logout();

        return $this->response()->noContent();
    }

    /**
     * 账号资料
     * @Versions({"v1"})
     * @Get("/bs/info/admin")
     * @Request(contentType="application/json")
     * @Response(200,body=null)
     */
    public function me() {
        return $this->response()->item(auth($this->guard)->user(), new UserTransformer());
    }

    /**
     * 刷新token
     * @Versions({"v1"})
     * @Get("/bs/refresh/admin")
     * @Request(contentType="application/json")
     * @Response(200,body=null)
     */
    public function refresh() {
        return $this->respondWithToken(auth($this->guard)->refresh());
    }
}