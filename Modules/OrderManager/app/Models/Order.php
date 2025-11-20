<?php

namespace Modules\OrderManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ProjectManager\Models\Site;
use Modules\OrderManager\Models\OrderItem;


// use Modules\OrderManager\Database\Factories\OrderFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
      protected $fillable = ['project_id','ordered_by','status','approved_by','approved_at','remarks'];

   

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function project()
    {
        return $this->belongsTo(Site::class, 'project_id');
    }

   
}
