<?php


namespace app\index\controller;


use app\admin\model\Articles;
use think\Controller;

class Search extends Controller
{

    public function search() {
        $text = input("post.text");
        $data = Articles::all(function ($query) use ($text) {
            $query->where('html', 'like', '%'.$text.'%');
        });
        return $this->fetch('index', [
            "data" => $data
        ]);
    }

}