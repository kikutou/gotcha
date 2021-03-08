<?php

namespace App\Services;

use App\Models\Picture;

class PictureService{
    public function getAll(){
        return Picture::all()->where('del_flg',0);
    }

    public function getNoDel(){
        return Picture::all()->where('del_flg',0);
    }

    public function getPictureById($id){
        return Picture::where('id', $id)->first();
    }

    public function create($data){
        return $picture = Picture::create([
            'description' => $data['description'],
            'type' =>$data['type_id'],
            'url' => $data['name'],
        ]);
    }

    public function up($data){
        return $picture = Picture::create([
            'description' => $data['description'],
            'type' =>$data['type_id'],
            'url' => $data['name'],
        ]);
    }
}
