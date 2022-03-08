<?php


namespace app\admin\controller;


use think\Controller;
use think\Request;

class AdminController extends Controller
{
    public function _initialize(){
        /**
         * 不验证用户登陆的页面
         */
        $this->checkUserLogin("Index/Login/login");
    }

    protected function checkUserLogin($redirect_url)
    {
        if(!session("?isAdmin") or intval(session("isAdmin")) != 1){
            $this->error('请先登陆.', $redirect_url);
        }
    }
}