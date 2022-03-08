<?php


namespace app\admin\controller;


use app\admin\model\Sensitives;

class Sensitive extends AdminController
{
    private $page_per = 10;

    public function index() {
        $results = [];
        $data = Sensitives::all(function ($query) {
            $query->order("id", "desc");
        });
        foreach ($data as $field => $item) {
            array_push($results, $item->text);
        }
        return $this->fetch('index', [
            "data" => $data,
            "pages" => ceil(count($data)/$this->page_per) + 1
        ]);
    }

    public function add() {
        $text = input("post.text");

        $data = Sensitives::create([
            "text" => $text
        ]);

        if($data->count() > 0) {
            $this->success("创建成功", 'Admin/Sensitive/index');
        }else {
            $this->error("创建失败", 'Admin/Sensitive/index');
        }

    }

    public function delete($id) {
        $data = Sensitives::get($id)->delete();
        if($data) {
            $this->success("删除成功", 'Admin/Sensitive/index');
        }else {
            $this->error("删除失败", 'Admin/Sensitive/index');
        }
    }
}