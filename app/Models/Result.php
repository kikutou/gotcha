<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Prize;
use App\Models\Gotcha;

class Result extends Model
{
    use HasFactory;

    protected $table = "results";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gotcha_id',
        'uid',
        'prize_id',
        'status'
    ];

    public function prize(){
        return $this->hasOne(Prize::class, 'id', 'prize_id')->withDefault();
    }
    public function gotcha(){
        return $this->hasOne(Gotcha::class, 'id', 'gotcha_id')->withDefault();
    }
}
