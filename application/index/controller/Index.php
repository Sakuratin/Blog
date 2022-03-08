<?php
namespace app\index\controller;
use app\admin\model\Articles;
use app\admin\model\Config;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $article = new Articles();
        $data = $article->getArticlesVisible();
        $hots = $article->getHotArticle();
        $latests = $article->getLatestArticle();
//        $categories = $article->getCategoryTop2();

        return $this->fetch('index', [
            "articles" => $data,
            "hots" => $hots,
            "latests" => $latests,
//            "categories" => $categories
        ]);
    }

    public function category($category) {
        $article = new Articles();
        $data = $article->getArticlesVisible4Category($category);
        $hots = $article->getHotArticle();
        $latests = $article->getLatestArticle();

        return $this->fetch('index', [
            "articles" => $data,
            "hots" => $hots,
            "latests" => $latests,
        ]);
    }

    public function read() {
        return $this->fetch("index");
    }

    public function test() {
        return $this->fetch();
    }

    public function about() {
        $config = new Config();
        return $this->fetch('about', [
            "about" => $config->getAbout()
        ]);
    }
}
