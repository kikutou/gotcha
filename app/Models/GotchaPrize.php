<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GotchaPrize extends Model
{
    use HasFactory;

    protected $table = "gotchas_prizes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gotcha_id',
        'prize_id',
        'frequency',
    ];

    public function prize(){
        return $this->hasOne(Prize::class, 'id', 'prize_id')->withDefault();
    }

    static public function getGotchaPrizeFrequency($gotcha_id, $prize_id){
        return GotchaPrize::query('select gotchas_prizes.frequency')
            ->from('gotchas_prizes')
            ->where('gotcha_id', $gotcha_id)
            ->where('prize_id', $prize_id)
            ->first();
    }
}
