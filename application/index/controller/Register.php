<?php


namespace app\index\controller;


use app\index\model\User;
use think\Controller;
use think\response\Json;


class Register extends Controller
{
    public function index() {
        return $this->fetch();
    }

    public function register() {
        $username = input("post.username");
        $password = input("post.password");
        $email = input("post.email");

        $user = new User;
        $data = $user->createUser($username, $password, $email, 0);

        if ($data) {
            return Json::create([
                "code" => 200,
                "message" => "创建成功"
            ]);
        }
        return Json::create([
            "code" => 400,
            "message" => "创建失败"
        ])->code(400);
    }
}