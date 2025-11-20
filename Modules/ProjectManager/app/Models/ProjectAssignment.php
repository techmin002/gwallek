<?php

namespace Modules\ProjectManager\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;

// use Modules\ProjectManager\Database\Factories\ProjectAssignmentFactory;

class ProjectAssignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'branch_id',
        'site_id',
        'manager_id',
        'staff_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
