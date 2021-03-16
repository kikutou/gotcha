<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Picture;

class Prize extends Model
{
    use HasFactory;
    use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = "prizes";
    
    public function picture(){
        return $this->hasOne(Picture::class, 'id', 'picture_id')->withDefault();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'picture_id',
    ];

    static public function getPrize(){
        // return Prize::query()->get();
        return Prize::query('select prizes.id as id, prizes.name as name, 
                            prizes.type as type, prizes.picture_id as picture_id, 
                            pictures.url as url')
            ->from('prizes')
            ->leftjoin('pictures',  'pictures.id', 'prizes.picture_id')
            ->get();
    }

    static public function getPrizeById($id){
        return DB::table('pictures')
            ->rightJoin('prizes', 'prizes.picture_id', '=', 'pictures.id')
            ->where('prizes.id', $id)
            ->first();
    }
}
