<?php
/**
 * Author: Link<https://github.com/linkdesu>
 */
namespace App;

//发送手机验证码失败
define('GET_VERIFY_CODE_FAIL', 10000);
define('MOBILE_VERIFY_FAIL',   10001);
define('MOBILE_VERIFY_TIMEOUT',10002);

/**
 * api 错误码
 *
 * 错误码定义规则如下：
 * 1. 根据注释说明分段定义
 * 2. 错误码正文： [500, '未知错误'] 其中 500 表示错误码应该使用的 http code ，'未知错误' 是返回给前端调试人员看的错误说明
 */
define('API_ERROR_CODE', [
    // 1 专门用来表示位置错误，尽量慎用
    1 => [500, '未知错误'],
    // 设备相关错误编码
    GET_VERIFY_CODE_FAIL => [500, '手机验证码发送失败'],
    MOBILE_VERIFY_FAIL   => [500, '手机验证码验证失败'],
    MOBILE_VERIFY_TIMEOUT => [500, '手机验证码超时']
]);
