<?php
namespace App\Http\Controllers\Auth\App;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Auth\Events\Registered;

use Illuminate\Http\Request;

use Auth;

use Illuminate\Support\Facades\Response;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /*移动端手机号为用户名*/
    public function username()
    {
        return 'mobile';
    }

    protected function guard()
    {
        return Auth::guard('app');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'mobile' => 'required|string|max:255',
            'code' => 'required|string|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'mobile' => $data['mobile']
        ]);
    }

    /* 覆盖 trait 中的 register 注册函数 */
    public function register(Request $request)
    {

        $data['mobile'] = $request->input('mobile');
        $data['code']   = $request->input('code');

        $this->validator($data)->validate();

        $this->verifyCode($data['mobile'], $data['code'], 'register_verifycode_');

        event(new Registered($user = $this->create($data)));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        $code = $this->oauth2Password($request->input('mobile'));

        return Response::json([
                'message' => "注册成功",
                'user' => $user,
                'code' => $code
        ]);
    }
    /*生成短信验证码*/
    public function getMobileVerifyCode(Request $request)
    {
        return $this->getVerifyCode($request, 'register_verifycode_');
    }
}
