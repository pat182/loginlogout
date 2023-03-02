<?php

namespace Modules\Permission\Entities;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Permission\Entities\Repositories\PermissionGroupRepository;


class PermissionType extends Model
{
    // use HasFactory;
    protected $table = 'permission_type';

    protected $fillable = ['permission'];
    
    protected $primaryKey = 'permission_type_id';
    
    public $timestamps = false;
    // protected static function newFactory()
    // {
    //     return \Modules\Permission\Database\factories\PermissionTypeFactory::new();
    // }
    public function scopeRoleAdmin($query){

        return $query->where('permission_type_id', '<>' ,1);
        
    }
    public function permissionGroup(){
        return $this->hasMany(PermissionGroupRepository::class,'permission_type_id','permission_type_id');
    }
}
