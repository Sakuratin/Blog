<?php

namespace app\index\controller;

use app\admin\model\Photos;
use think\Controller;
use think\Db;

class Photo extends Controller
{
    public function index() {
        $photo = new Photos();
        $categories = $photo->getLatestCover();

        return $this->fetch("index", [
            "categories" => $categories
        ]);
    }

    public function photolist($pcid) {
        $p = new Photos();
        return $this->fetch("list", [
            "categories" => $p->getPhotoList($pcid)
        ]);
    }
}