<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    'login' => 'index/index/login',
    'VerifyLogin' => 'index/login/login',
    'logout' => 'show/index/logout',
    'regist' => 'index/index/regist',
    'VerifyRegist' => 'index/regist/regist',
    'show/:id' => 'show/index/index',
    'admin' => 'admin/index/index',
    'updateimg' => 'admin/index/updateimg',
    'updatenews' => 'admin/index/updatenews',
    'honeypot' => 'index/Login/GetIP',
];
