<?php


namespace app\admin\controller;


use app\admin\model\Config;
use think\response\Json;

class Setting extends AdminController
{

    public function index() {
        return $this->fetch();
    }

    public function about() {
        $config = new Config();

        if(input("?post.about") && input("?post.aboutHtml")) {
            $about = input("post.about");
            $aboutHtml = input("post.aboutHtml");


            $data = $config->updateConfig([
                "about" => $about,
                "aboutHtml" => $aboutHtml
            ]);

            if($data) {
                return Json::create([
                    "code" => 200,
                    "message" => "保存成功"
                ])->code(200);
            }else{

                return Json::create([
                    "code" => 400,
                    "message" => "保存失败"
                ])->code(400);
            }
        }else {
            $data = $config->getConfigs();
            return $this->fetch('about', [
                "data" => $data
            ]);
        }
    }
}