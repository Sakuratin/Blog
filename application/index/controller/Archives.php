<?php


namespace app\index\controller;
use app\admin\model\Articles;
use think\Controller;


class Archives extends Controller
{
    public function index() {
        $article = new Articles();
        $archives = $article->getArchives();

        return $this->fetch('index', [
            "archives" => $archives
        ]);
    }
}