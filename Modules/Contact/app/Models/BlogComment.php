<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Blog\Entities\Blog;

// use Modules\Contact\Database\Factories\BlogCommentFactory;

class BlogComment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'blog_id',
        'name',
        'email',
        'website',
        'comment',
        'status',
    ];
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    // protected static function newFactory(): BlogCommentFactory
    // {
    //     // return BlogCommentFactory::new();
    // }
}
