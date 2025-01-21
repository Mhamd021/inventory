<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journey extends Model
{
    use HasFactory;
    use HasSpatial;
    use SoftDeletes;

    protected $fillable = [
        'headline',
        'start_day',
        'last_day' ,
        'description',
        'journey_charg',
        'max_number',
        'deleted_at'
    ];
    protected $dates = ['deleted_at'];

    public function Points()
    {
        return $this->hasMany(Points::class);
    }
}
