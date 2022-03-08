<?php


namespace app\index\model;
use think\Model;


class User extends Model
{
    protected $table = "users";
    protected $pk = "id";

    public function getUsers() {
        return User::all(function ($query) {
            $query->field("username, password");
        });
    }

    public function verify($username, $password, $is_admin = 0) {
        $data = User::where([
            "username" => $username,
            "password" => $password
        ]);

        $user = $data->find()->data;

        if ($user) {
            session("user", $user['username']);
            session("userId", $user['id']);
            session("isAdmin", $user['is_admin']);
            return true;
        }else{
            return false;
        }
    }

    public function createUser($username, $password, $email, $is_admin = 0) {
        $data = User::create([
            "username" => $username,
            "password" => $password,
            "is_admin" => $is_admin,
            "email" => $email
        ]);
        return $data->count() > 0;

    }
}