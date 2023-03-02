<?php

namespace Modules\Permission\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Permission\Entities\Repositories\PermissionGroupRepository;


class Permission extends Model
{
    // use HasFactory;
    protected $table = 'permission';

    protected $primaryKey = 'permission_id';

    protected $fillable = [
        "action_description",
        "action",
        "group_id",
        "end_point",
        "method"
    ];
    
    public $timestamps = false;

    
}
