<?php

namespace Modules\Permission\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Permission\Entities\Repositories\PermissionRepository;
// use Modules\Permission\Entities\Repositories\PermissionTypeRepository;

class PermissionGroup extends Model
{
    // use HasFactory;
    protected $table = 'permission_group';

    protected $primaryKey = 'permission_type_id';

    protected $fillable = [
        "permission_type_id",
        "permission_id"
    ];
    
    public $timestamps = false;


    public function permissionRole(){
        return $this->hasOne(PermissionRepository::class,"permission_id","permission_id");
    }
    // protected static function newFactory()
    // {
    //     return \Modules\Permission\Database\factories\PermissionFactory::new();
    // }
}
