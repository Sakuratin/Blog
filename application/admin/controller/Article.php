<?php


namespace app\admin\controller;

use app\admin\model\Articles;
use app\admin\model\Sensitives;
use think\response\Json;

class Article extends AdminController
{

    private $page_per = 10;

    public function index() {
        $article = new Articles();
        $data = $article->getArticles();
        return $this->fetch('index', [
            "articles" => $data,
            "pages" => ceil(count($data)/$this->page_per) + 1
        ]);
    }

    public function create() {
        return $this->fetch();
    }

    public function save() {

        $sens = new Sensitives();

        $title = input("post.title");
        $markdown = input("post.markdown");
        $html = input("post.html");
        $category = input("post.category");
        $visible = input("post.visible");
        $lock = input("post.lock");

        // 过滤文章内容
        $markdown = $sens->filterComment($markdown);
        $html = $sens->filterComment($html);

        $article = new Articles;
        $data = $article->create_post($title, $markdown, $html, $category, $visible, $lock);

        if($data) {
            return Json::create([
                "code" => 200,
                "message" => "创建成功"
            ])->code(200);
        }else {
            return Json::create([
                "code" => 400,
                "message" => "创建失败"
            ])->code(400);
        }
    }

    public function edit($id) {
        $article = Articles::get([
            "id" => $id
        ]);

        return $this->fetch('edit', [
            "id" => $article->id,
            "title" => $article->title,
            "markdown" => $article->markdown,
            "html" => $article->html,
            "category" => $article->category,
            "visible" => $article->visible,
            "lock" => $article->lock
        ]);
    }

    public function update($id) {
        $title = input("post.title");
        $markdown = input("post.markdown");
        $html = input("post.html");
        $category = input("post.category");
        $visible = input("post.visible");
        $lock = input("post.lock");

        $article = new Articles;
        $data = $article->update_post($id, $title, $markdown, $html, $category, $visible, $lock);

        if($data) {
            return Json::create([
                "code" => 200,
                "message" => "更新成功"
            ])->code(200);
        }else {
            return Json::create([
                "code" => 400,
                "message" => "更新失败"
            ])->code(400);
        }
    }

    public function delete($id) {
        $data = Articles::get($id)->delete();
        if ($data) {
            $this->success("删除成功", "Admin/Article/index");
        }else {
            $this->error("删除失败", "Admin/Article/index");
        }
    }

}