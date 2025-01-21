<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class Points extends Model
{
    use HasFactory;
    use HasSpatial;
    protected static function boot() {
         parent::boot();
          static::deleting(function ($point)
           {
            if ($point->image)
             {
                File::delete($point->image);
             }
             });
             }
    protected $fillable =
    [
        'journey_id',
        'order',
        'point_description',
        'image',
        'location',
    ];
    protected $casts = [

        'location' => Point::class,
    ];

    public function journey()
    {
        return $this->belongsTo(Journey::class);
    }
}
