<?php
namespace app\admin\controller;


use app\admin\model\Users;
use think\Db;

class User extends AdminController
{
    private $page_per = 10;

    public function index() {
        $users = new Users();
        $data = $users->getUsers();

        return $this->fetch('index', [
            "users" => $data,
            "pages" => ceil(count($data)/$this->page_per) + 1
        ]);
    }

    public function show($id) {
        $user = new Users();
        return $this->fetch('show', [
            "user" => $user->getUser($id)
        ]);
    }

    public function update($id) {
        $password = input("post.password");
        $email = input("post.email");
        $user = new Users();
        $data = $user->updateUser($id, $password, $email);

        if($data) {
            $this->success("更新成功", "Admin/User/index");
        }else {
            $this->error("更新失败", "Admin/User/index");
        }
    }

    public function delete($id) {
        $data = Users::get($id);

        if($data->is_admin) {
            $this->error("删除失败, 无法删除管理员", "Admin/User/index");
        }else {
            $data = $data->delete();

            if($data) {
                $this->success("删除成功", "Admin/User/index");
            }else {
                $this->error("删除失败", "Admin/User/index");
            }
        }
    }

}