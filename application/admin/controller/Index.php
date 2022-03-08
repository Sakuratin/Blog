<?php


namespace app\admin\controller;


use app\admin\model\Articles;
use think\Controller;

class Index extends AdminController
{

    public function index() {
        $comments = new \app\admin\model\Comments();
        $articles = new Articles();

        return $this->fetch('index', [
            "articles" => $articles->getLatestArticle(),
            "comments" => $comments->getLatestComments()
        ]);
    }
}