<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'WEB_TITLE' => "拾香得味",
    'APP_ID' => "wxc78c73cf4012af64",
    'APP_SECRET' => "b5cb9f7a16b03f279cc2a0c60eba9d5b",
    
    'LOGIN_TYPE_WX' => 1,//微信登录
    'LOGIN_TYPE_ACCOUNT' => 2,//账户登录
    
    'GLOBAL_WX_ACCESTOKEN_NAME'=>  'accesstoken',//全局变量微信accesstoken的名称
    'GLOBAL_WX_ACCESTOKEN_time' =>  '5000',//全局变量微信accesstoken的过期时间为5000秒
    
    'ROLE' => [
        '1' => '管理员',//邮箱已验证
        '10' => '普通账户',//邮箱未验证
    ],
    
    
    'STATU_R' => [
        '10' => '可以使用',//可以使用的账户
        '0' => '禁止使用',//禁止使用的账户
    ],
    'STATU' => [
        'COMMON' => '10',//可以使用的账户
        'FORBID' => '0',//禁止使用的账户
    ],
    
    'IMAGE_FILE' => [
            'TYPE' => ["image/jpg", "image/jpeg", "image/png"],//限制上传图片的格式
            'MAXSIZE' => 1024*1024*2,//上传图片最大不能大于2M 
            ],
];
