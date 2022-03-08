<?php


namespace app\admin\model;


use think\Model;

class Sensitives extends Model
{
    protected $table = "sensitives";
    protected $pk = "id";

    public function getSensitives() {
        $data = [];
        foreach (Sensitives::all() as $key => $item) {
            array_push($data, $item->text);
        }

        return $data;

    }

    public function filterComment($comment) {
        $data = $this->getSensitives();
        foreach ($data as $item) {
            $comment = preg_replace('/'.$item.'/i', '**', $comment);
        }
        return $comment;
    }

}