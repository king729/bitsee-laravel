<?php
namespace App\Http\Controllers\Auth\App;

use Illuminate\Support\Facades\Auth;

use Cache;

use Illuminate\Support\Facades\Response;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /*移动端手机号为用户名*/
    public function username()
    {
        return 'mobile';
    }

    protected function guard()
    {
        return Auth::guard('app');
    }

    /* 覆盖 验证规则 取消密码登录方式 */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'code' => 'required|string',
        ]);

        $code   = $request->input('code');
        $mobile = $request->input('mobile');

        $this->verifyCode($mobile, $code, 'login_verifycode_');

    }

    /*生成短信验证码*/
    public function getMobileVerifyCode(Request $request)
    {
        return $this->getVerifyCode($request, 'login_verifycode_');
    }

    /**
     * overwrite the function in trait
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
    */
    protected function authenticated(Request $request, $user)
    {
        //
        $code = $this->oauth2Password($request->input('mobile'));

        return Response::json([
                'message' => "登录成功",
                'user' => $user,
                'code' => $code
        ]);
    }
}