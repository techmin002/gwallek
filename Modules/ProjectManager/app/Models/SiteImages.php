<?php

namespace Modules\ProjectManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\ProjectManager\Database\Factories\SiteImagesFactory;

class SiteImages extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'site_images'; // make sure table name is correct

    protected $fillable = [
        'site_id',
        'image',
        'status',
    ];


    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    // protected static function newFactory(): SiteImagesFactory
    // {
    //     // return SiteImagesFactory::new();
    // }
}
