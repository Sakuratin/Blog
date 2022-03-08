<?php


namespace app\admin\model;


use think\Model;

class Comments extends Model
{
    protected $table = "comments";
    protected $pk = "id";

    public function create_comments(
        $article, $article_title, $user, $username, $comment
    ) {

        $sensitive = new Sensitives();
        $comment = $sensitive->filterComment($comment);
        $data = Comments::create([
            "aid" => $article,
            "userid" => $user,
            "username" => $username,
            "comment" => $comment,
            "atitle" => $article_title
        ]);
        return $data->count() > 0;
    }

    public function getComments($id) {

        $results = [];

        $data = Comments::all(function ($query) use ($id) {
            $query->where("aid", $id)->order("id", "desc");
        });

        foreach ($data as $_ => $value) {
            array_push($results, $value->data);
        }
//        dump($results);
        return $results;
    }

    public function getAllComments() {
        $results = [];
        $data = Comments::all();

        foreach ($data as $_ => $value) {
            array_push($results, $value->data);
        }
        return $results;
    }

    public function getLatestComments() {
        $results = [];
        $data = Comments::all(function ($query) {
            $query->order("id", "desc")->limit(10);
        });

        foreach ($data as $_ => $value) {
            array_push($results, $value->data);
        }
        return $results;
    }
}