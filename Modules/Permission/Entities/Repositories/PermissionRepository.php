<?php

namespace Modules\Permission\Entities\Repositories;

use Modules\Permission\Entities\Permission;

class PermissionRepository extends Permission
{
	/**
    * @return string
    */
    private function getPermission($col){
        return self::select($col);
    }
    public function addPermission($data){
        
        $permission = self::create($data);
        return $permission->permission_id;
    }
    public function permAuto($query){
        $perms = $this->getPermission(['*'])->where('action_description','LIKE', '%' . $query . '%')->get();
        if(count($perms))
            $data = $perms;
        else
            $data = null;
        return $data;
    }
}