<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Prize;

class Picture extends Model
{
    use HasFactory;
    use SoftDeletes;

	protected $dates = ['deleted_at'];

    public function prizes(){
        return $this->belongsTo(Prize::class, 'picture_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'type',
        'url',
    ];

}
