<?php


namespace app\index\controller;
use app\admin\model\Articles;
use app\admin\model\Comments;
use think\Controller;


class Article extends Controller
{

    public function index($id = null) {
        $article = new Articles();
        $comments = new Comments();
        $isLock = true;

        $data = $article->getArticle($id);
        $article->updateArticleView($id, $data['view'] + 1);

        if(trim($data['lock']) == "") {
            $isLock = false;
        }else if(input("?post.lock") && trim($data['lock']) == trim(input("post.lock"))) {
            $isLock = false;
        }

        return $this->fetch("index", [
            "article" => $data,
            "comments" => $comments->getComments($id),
            "isLock" => $isLock
        ]);
    }

    public function comment($id) {
        if(session("?user")) {
            $userId = session("userId");
            $username = session("user");
            $text = input("post.comment");

            $comment = new Comments();
            $article = new Articles();
            $article_title = $article->getArticle($id)['title'];

            $data = $comment->create_comments(
                $id, $article_title, $userId, $username, $text
            );

            if($data) {
                $this->success("评论成功");
            }else{
                $this->error("评论失败");
            }
        }else {
            $this->error("未登录无法评论", "Index/Login/index");
        }
    }

    public function delcomment($id) {
        if(session("?user")) {
            $userId = session("userId");

            if(Comments::get(["id" => $id, "userid" => $userId])->delete()) {
                $this->success("删除成功");
            }else{
                $this->error("删除失败");
            }
        }else{
            $this->error("未登录无法删除评论", "Index/Login/index");
        }
    }

}