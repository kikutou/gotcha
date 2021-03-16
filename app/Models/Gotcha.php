<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gotcha extends Model
{
    use HasFactory;
    use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = "gotchas";

    public function picture(){
        return $this->hasOne(Picture::class, 'id', 'picture_id')->withDefault();
    }

    public function result_picture(){
        return $this->hasOne(Picture::class, 'id', 'result_picture_id')->withDefault();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cost_name',
        'cost_value',
        'pitcure_id',
        'result_pitcure_id  ',
        'use_numbers',
        'del_flg',
    ];

    public function prizes()
    {
    	return $this->belongsToMany(Prize::class, "gotchas_prizes", "gotcha_id", "prize_id");
    }
}
