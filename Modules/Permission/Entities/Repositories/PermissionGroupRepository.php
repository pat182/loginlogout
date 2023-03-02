<?php

namespace Modules\Permission\Entities\Repositories;

use Modules\Permission\Entities\PermissionGroup;


class PermissionGroupRepository extends PermissionGroup
{
	/**
    * @return string
    */
    private function getGroup($data){
        return $this->where($data);
    }
    public function addGroupPermission($data){

        $permission = self::updateOrCreate($data);
        if(!$permission->wasRecentlyCreated && !$permission->wasChanged())
            return false;
        else
            return true;
    }
    public function remPerm($data){
        $permission = $this->getGroup($data);
        $data = $permission->get();
        if(count($data))
            if(count($data) > 1)
                $permission = self::destroy($data);    
            else
                $permission = $permission->delete();
        else
            $permission = null;
        return $permission;
    }
}