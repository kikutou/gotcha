<?php

namespace App\Services;

use App\Models\Prize;

class PrizeService{
    public function getPrize(){
        return Prize::all();
    }

    public function getPrizeById($id){
        return Prize::where('id', $id)->get();
    }
}
