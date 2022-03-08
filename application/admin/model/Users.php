<?php


namespace app\admin\model;


use think\Model;

class Users extends Model
{
    protected $table = "users";
    protected $pk = "id";

    public function getUsers() {
        $results = [];
        $data = Users::all();

        foreach ($data as $_ => $user) {
            array_push($results, $user->data);
        }
        return $results;
    }

    public function getUser($id) {
        $user = Users::get([
            "id" => $id
        ]);
        return $user->data;
    }

    public function getUserByEmail($email) {
        $user = Users::get([
            "email" => $email
        ]);
        return $user->data;
    }

    public function updateUser($id, $password, $email) {
        $data = Users::where([
            "id" => $id
        ])->update([
            "password" => $password,
            "email" => $email
        ]);

        if($data) {
            return true;
        }
        return false;
    }
    public function hasEmail($email) {
        $data = Users::where([
            "email" => $email,
        ]);
        return $data->count() > 0;
    }

}