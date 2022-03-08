<?php


namespace app\admin\model;


use think\Db;
use think\Model;


function getplaintextintrofromhtml($html) {

    // Remove the HTML tags
    $html = strip_tags($html);
    // Convert HTML entities to single characters
    $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
    return $html;
}


class Articles extends Model
{
    protected $table = "articles";
    protected $pk = "id";
    protected $auto = ['create_time'];

    public function getCreateTimeAttr($time)
    {
        return $time;
    }

    public function create_post($title, $markdown, $html, $category = "默认", $visible = 1, $lock="") {

        $description = getplaintextintrofromhtml($html);
        $description = mb_substr($description, 0, strpos($description, "。") < 90 ? strpos($description, "。")+1: 90);

        $data = Articles::create([
            "title" => $title,
            "markdown" => $markdown,
            "html" => $html,
            "category" => $category,
            "visible" => $visible,
            "description" => $description,
            "lock" => trim($lock),
            "create_time" => date("Y-m-d H:i:s")
        ]);

        if($data -> count() > 0) {
            return true;
        }else {
            return false;
        }
    }

    public function update_post($id, $title, $markdown, $html, $category = "默认", $visible = 1, $lock = "") {

        $description = getplaintextintrofromhtml($html);
        $description = mb_substr($description, 0, strpos($description, "。") < 90 ? strpos($description, "。")+1: 90);

        $data = Articles::where("id", $id)->update([
            "title" => $title,
            "markdown" => $markdown,
            "html" => $html,
            "category" => $category,
            "visible" => $visible,
            "description" => $description,
            "lock" => $lock
        ]);

        if($data > 0) {
            return true;
        }else {
            return false;
        }
    }

    public function getArticles() {
        $data = Articles::all(function ($query) {
            $query = $query->order("id", "desc");
        });
        $result = [];

        foreach ($data as $field => $item) {
            array_push($result, $item->data);
        }
        return $result;
    }

    public function getCategoryTop2() {
        $data = Db::query("SELECT category, COUNT(*) from articles GROUP BY category ORDER BY COUNT(*) DESC LIMIT 0, 2");
        return $data;
    }

    public function getArticlesVisible() {
        $data = Articles::all(function ($query) {
            $query = $query->where("visible", 1)->order("id", "desc");
        });
        $result = [];

        foreach ($data as $field => $item) {
            array_push($result, $item->data);
        }
        return $result;
    }

    public function getArticlesVisible4Category($category) {
        $data = Articles::all(function ($query) use ($category) {
            $query = $query->where("visible", 1)->where("category", $category)->order("id", "desc");
        });
        $result = [];

        foreach ($data as $field => $item) {
            array_push($result, $item->data);
        }
        return $result;
    }

    public function getArticle($id) {
        $data = Articles::get([
            "id" => $id
        ])->data;
        return $data;
    }

    public function getHotArticle() {
        /**
        获取最热门的文章
         */
        $data = Articles::all(function ($query) {
            $query->where([
                "visible" => 1
            ])->order("view", "desc")->limit(5);
        });
        return $data;

    }

    public function getLatestArticle() {
        /**
        获取最新的文章
         */
        $data = Articles::all(function ($query) {
            $query->where([
                "visible" =>1
            ])->order("id", "desc")->limit(5);
        });
        return $data;
    }

    public function getArchives() {
        $data = Articles::all([
            "visible" => 1
        ]);
        $result = array();

        foreach ($data as $_ => $articles) {
            $item = $articles->data;
            $current_year = substr($item['create_time'], 0, 4);

            if(!array_key_exists($current_year, $result)) {
                $result[$current_year] = [];
            }

            $item['create_time'] = substr($item['create_time'], 0, 10);
            array_push($result[$current_year], $item);
        }
        return $result;

    }

    public function updateArticleView($id, $view) {
        $data = Articles::where("id", $id)->update([
            "view" => $view
        ]);
    }
}