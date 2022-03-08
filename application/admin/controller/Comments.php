<?php


namespace app\admin\controller;


class Comments extends AdminController
{

    private $page_per = 10;

    public function index() {

        $comment = new \app\admin\model\Comments();

        return $this->fetch('index', [
            "comments" => $comment->getAllComments(),
            "pages" => ceil(count($comment)/$this->page_per) + 1
        ]);
    }

    public function delete($id) {

        $data = \app\admin\model\Comments::get($id)->delete();
        if($data) {
            $this->success("删除成功");
        }else {
            $this->error("删除失败");
        }
    }
}