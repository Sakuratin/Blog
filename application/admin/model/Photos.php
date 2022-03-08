<?php


namespace app\admin\model;


use think\Db;
use think\Model;

class Photos extends Model
{

    protected $table = "photos";
    protected $pk = "id";

    public function getPhotoCategories() {
        $data = Db::query("SELECT * from photocategory");
        return $data;
    }

    public function getLatestCover() {
        $results = [];
        foreach ($this->getPhotoCategories() as $item) {

            $data = $this->where([
                "pcid" => $item['id']
            ])->order("id", 'desc')->limit(1)->find();
//            var_dump($data);

            if($data) {
                $item['cover'] = $data->data['path'];
                array_push($results, $item);
            }
        }
        return $results;
    }

    public function getPhotoList($id) {
        $results = [];

        $data = Photos::all(function ($query) use ($id) {
            $query->where("pcid", $id)->order("id", "desc");
        });

        foreach ($data as $_ => $value) {
            array_push($results, $value->data);
        }
        return $results;
    }

}