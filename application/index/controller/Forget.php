<?php

namespace app\index\controller;

use app\admin\model\Users;
use think\Controller;
use think\Db;
use think\Request;

class Forget extends Controller
{

    public function index() {
        $request = Request::instance();

        if(request()->isGet()) {
            return $this->fetch('index', [
            ]);
        }else {
            $users = new Users();
            $email = input("post.email");

            if(!$users->hasEmail($email))
                $this->error("邮箱不存在");

            $random_uuid = create_uuid();
            Db::table("code")->insert([
                "code" => $random_uuid,
                "email" => $email
            ]);
            sendEmail(
                "赵婷婷的小窝 - 密码重置",
                "重置链接 ".$request->domain().$request->root()."/reset/".$random_uuid,
                $email
            );
            $this->success("密码重置链接已发送, 请通过接收到的链接进行密码重置。");
        }
        return ;
    }

    public function reset($token) {

        $data = Db::table("code")->where([
            "code" => $token
        ])->find();

        if($data === null) {
            $this->error("Token错误");
        }

        if(request()->isGet()) {
            return $this->fetch("reset", [
                "token" => $token
            ]);
        }else {
            $users = new Users();

            if(!input("?post.password")) {
                $this->error("缺少参数password");
            }

            // 获取对应邮箱的用户
            $user = $users->getUserByEmail($data['email']);
            $users->updateUser($user['id'], input("post.password"), $user['email']);


            Db::table("code")->where([
                "code" => $token
            ])->delete();

            $this->success("密码重置成功", 'Index/Index/index');

        }

        return ;
    }
}