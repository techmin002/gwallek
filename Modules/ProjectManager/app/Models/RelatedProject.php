<?php

namespace Modules\ProjectManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\ProjectManager\Database\Factories\RelatedProjectFactory;

class RelatedProject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'site_id',
        'name',
        'image',
        'description',
        'status',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
    // protected static function newFactory(): RelatedProjectFactory
    // {
    //     // return RelatedProjectFactory::new();
    // }
}
