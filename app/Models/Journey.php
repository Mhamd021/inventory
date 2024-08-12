<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Point;
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
        'start_point',
        'end_point',
        'description',
        'journey_charg',
        'max_number',
        'deleted_at'
    ];

    protected $casts = [
        'start_point' => Point::class,
        'end_point' => Point::class,
    ];
    protected $dates = ['deleted_at'];
}
