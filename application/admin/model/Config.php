<?php


namespace app\admin\model;


use think\Model;

class Config extends Model
{

    protected $table = "configs";

    public function create_init() {
        Config::create([
            "site" => "",
            "about" => "",
            "aboutHtml" => ""
        ]);
    }

    public function getConfigs() {
        $results = [];

        $data = Config::all();
        if(count($data) == 0) {
            $this->create_init();
            return $this->getConfigs();
        }

        foreach ($data as $_ => $item) {
            array_push($results, $item->data);
        }
        return $results[0];
    }

    public function updateConfig($data) {
        $config = Config::all()[0];
        return Config::where("id", $config->data['id'])->update($data);
    }

    public function getAbout() {
        $config = Config::all()[0];
        return Config::where("id", $config->data['id'])->find()->data['aboutHtml'];
    }
}