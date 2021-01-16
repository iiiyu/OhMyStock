<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Http\Controllers\AuthController as BaseAuthController;

class AuthController extends BaseAuthController
{
    // 自定义登陆view模板
    protected $view = 'admin.pages.login';
}
