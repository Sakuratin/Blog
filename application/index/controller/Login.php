<?php


namespace app\index\controller;
use think\Controller;
use app\index\model\User;
use think\Db;
use think\Response;
use think\response\Json;


class Login extends Controller
{
    public function index() {
        return $this->fetch();
    }

    public function login() {
        $username = input("post.username");
        $password = input("post.password");

        $user = new User;
        $data = $user->verify($username, $password);

        if ($data) {

            return Json::create([
                "code" => 200,
                "message" => "登陆成功"
            ]);
        }
        return Json::create([
            "code" => 400,
            "message" => "登陆失败"
        ])->code(400);
    }

    function logout() {
        session(null);
        $this->success("退出成功", 'Index/Login/login');
    }
}