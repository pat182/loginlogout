<?php

namespace Modules\Permission\Entities\Repositories;

use Modules\Permission\Entities\PermissionType;

class PermissionTypeRepository extends PermissionType
{
	/**
    * @return string
    */
    private function findType(array $col){
        return self::select($col);
    }
    public function addPermission($data){
        $permission = self::create(["permission" => $data]);
        return $permission->permission_type_id;
    }
    public function delType($id){
        $type = $this->findType(['*'])->where('permission_type_id' , $id);
        if($type->first()){
            try{
                $type = $type->delete();
            }
            catch(\Exception $ex){
                $type = $ex;
            }
        }
        else
            $type = null;
        return $type;
    }
    public function getPermisssion($id){
        $permission_type = $this->findType(['*'])->where('permission_type_id',$id);
        $permission = $permission_type->with('permissionGroup.permissionRole')->first();
        if($permission)
            $permission = $this->formatData($permission->toArray());
        return $permission;
    }
    public function getRoleMtx($params){
        $query = $this->findType(['*'])->where($params)->orderBy('permission_type_id','Asc');
        $data = $query->with('permissionGroup.permissionRole')->get()->toArray();
        $n_data = [];
        if(count($data)){
            foreach ($data as $key => $value) {
                array_push($n_data,$this->formatData($value));
            }
        }
        return $n_data;
    }
    public function roleAuto($string){
        
        $user = auth()->user();

        $query = $this->findType(['*'])
        ->where(function($q) use ($user){

            if(!$user)

                $q->RoleAdmin();
               
            
        });
        $query = $query->orderBy('permission_type_id','Asc')->get();

        if(count($query))
            $data = $query;
        else
            $data = null;
        return $data;
    }
    protected function formatData(array $data) : array
    {
        return [
            "permission_type_id" => $data['permission_type_id'],
            "permission" => $data["permission"],
            "permission_group" => array_map(function($item){
                return [
                    "permission_id" => $item['permission_id'], 
                    "permission_role" => [
                        "action_description" => $item['permission_role']["action_description"],
                        "action" => $item['permission_role']["action"],
                        "'method" => $item['permission_role']["method"]
                    ]
                ];
            },$data['permission_group'])
        ];
    }
}