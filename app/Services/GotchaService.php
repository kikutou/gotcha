<?php

namespace App\Services;

use App\Models\Gotcha;

class GotchaService{
    public function getGotcha(){
        return Gotcha::all();
    }

    public function getGotchaById($id){
        return Gotcha::where('id', $id)->get();
    }
}
