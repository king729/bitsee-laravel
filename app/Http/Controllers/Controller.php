<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\SmsAliyun;

use App\Exceptions\ApiException;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;

use Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function verifyCode($mobile, $code, $prefix)
    {
    	if (Cache::has($prefix.$mobile)) {
            $value = Cache::get($prefix.$mobile);

            if ($value == $code) {
                 //Cache::pull($prefix.$mobile);
            } else {
                throw new ApiException(MOBILE_VERIFY_FAIL);
            }
        } else {
            throw new ApiException(MOBILE_VERIFY_TIMEOUT);
        }
    }

    protected function getVerifyCode(Request $request, $prefix)
    {
    	$mobile = $request->input('mobile');
        $verify=rand(100000,999999);
        $content='{"name":"'.$verify.'"}';
        //'DX_TEMPLATECODE'     => 'SMS_33705826',  //验证码短信模板代码
        $template='SMS_109335149';

        $response = SmsAliyun::sendSms(
           "微伴科技", // 短信签名
           $template, // 短信模板编号
           $mobile, // 短信接收者
           Array(  // 短信模板中字段的值
             "name"=>$verify
           ),
           "789"   // 流水号,选填
           );
        if ($response->Code == 'OK') {
             $minutes="60";
             Cache::put($prefix.$mobile, $verify, $minutes);
             return Response::json([
                'message' => "发送成功",
             ]);
        } else {

             throw new ApiException(GET_VERIFY_CODE_FAIL);

        }
    }

    protected function oauth2Password($mobile)
    {
        $http = new \GuzzleHttp\Client(['exceptions' => false, 'CURLOPT_SSL_VERIFYPEER' => false]);


        $response = $http->post('http://172.104.112.35:8000/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '4',
                'client_secret' => 'V6tnI3QtOa2HK2DZ9xattfAUpEplVfCXu8WiT2SR',
                'username' => $mobile,
                'password' => '',
                'scope' => '',
            ],
        ]);

        return json_decode((string)$response->getBody(), true);
    }
}
