<?php
namespace app\admin\controller;


use think\response\Json;

class Logout extends AdminController
{

    function logout() {
        session(null);
        $this->success("退出成功", 'Index/Login/login');
//        return Json::create("退出成功")->code(200);
    }
}