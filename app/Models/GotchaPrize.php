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
}
