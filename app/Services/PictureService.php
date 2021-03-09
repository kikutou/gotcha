<?php

namespace App\Services;

use App\Models\Picture;

class PictureService{
    public function getAll(){
        return Picture::all();
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
            'url' => $data['url'],
        ]);
    }

    public function up($data){
        $picture = Picture::find($data['id']);
        $picture->description = $data['description'];
        $picture->type = $data['type_id'];
        if(!empty($data['url'])){
            $picture->url = $data['url'];
        }
        $picture->save();
        return $picture = Picture::where('id', 1)->update([
            'description' => $data['description'],
            'type' =>$data['type_id'],
            'url' => $data['url'],
        ]);
    }

    public function delete($id){
        return $picture = Picture::where('id', $id)->delete();
    }
}
