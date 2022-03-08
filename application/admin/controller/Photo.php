<?php


namespace app\admin\controller;


use app\admin\model\Photos;
use think\Db;

class Photo extends AdminController
{

    private $page_per = 10;

    public function index() {
        $photo = new Photos();
        $data = $photo->getPhotoCategories();
//        $data = [];
        return $this->fetch('index', [
            "data" => $data,
            "pages" => ceil(count($data)/$this->page_per) + 1
        ]);
    }

    public function photolist($id) {
        $photo = new Photos();
        $data = $photo->getPhotoList($id);
//        var_dump($data);
        return $this->fetch('list', [
            "pcid" => $id,
           "data" => $data,
            "pages" => ceil(count($data)/100) + 1
        ]);
    }

    public function upload() {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        if(!input("?post.pcid")) {
            $this->error("错误的PCID");
        }

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info) {
                $path = $info->getSaveName();
                Photos::create([
                    "name" => $info->getFilename(),
                    "path" => $path,
                    "pcid" => request()->post("pcid")
                ]);
            }
        }
        $this->success("上传成功");
    }

    public function add() {
        if(request()->isPost()) {
            Db::table("photocategory")->insert([
               "name" => input("post.category")
            ]);
            $this->success("添加成功");
        }
        $this->error("非法请求");
    }

    public function delete($id) {
        $p = new Photos();
        $p->where([
            "id" => $id
        ])->delete();
        $this->success("删除成功");
    }


}