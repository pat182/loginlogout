<?php

namespace Modules\Permission\Services;

use Modules\Permission\Entities\Repositories\PermissionRepository;
use Modules\Permission\Entities\Repositories\PermissionTypeRepository;
use Modules\Permission\Entities\Repositories\PermissionGroupRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    private $permissionTypeRepo;
    private $permisssionRepo;
    private $permissionGroupRepo;
    protected $status;
    private $flag;

    public function __construct(PermissionTypeRepository $permissionTypeRepo,
                                PermissionRepository $permissionRepo,
                                PermissionGroupRepository $permissionGroupRepo){

        $this->permissionTypeRepo = $permissionTypeRepo;
        $this->permissionRepo = $permissionRepo;
        $this->permissionGroupRepo = $permissionGroupRepo;
        // $this->status = [];
    }
    protected function formatStatus($code,$msg,$data = null) : void {
        $this->status["code"] = $code;
        $this->status["msg"] = $msg;
        if($data)
            $this->status["data"] = is_array($data) ? $data : $data->toArray(); 
        else
            $this->status["data"] = [];
        // return $this->status;
    }

    public function addPermType($payload){
        $this->flag = true;

        DB::beginTransaction();
        $perm_id = $this->permissionTypeRepo->addPermission($payload['permission']);
        if($perm_id){
            if(!empty($payload['permission_ids'])){
               foreach ($payload['permission_ids'] as $value) {
                   if($this->permissionGroupRepo->addGroupPermission(
                        [
                            'permission_type_id' => $perm_id,
                            'permission_id' => $value
                        ]
                    )){
                        $this->flag = true;
                   }
                   else{
                        $this->flag = false;
                        break;
                   }
               }
            }
            if($this->flag){
                DB::commit();
                $this->formatStatus(200,config('permission.constants.messages.succ'));    
            }
            else{
                DB::rollback();
                $this->formatStatus(400,config('permission.constants.messages.fail'));
            }
        }   
        else
            $this->formatStatus(400,config('permission.constants.messages.fail'));

        return $this->status; 
    }
    public function addPerm($payload){
        if($this->permissionRepo->addPermission($payload))
            $this->formatStatus(200,config('permission.constants.messages.succ'));
        else
            $this->formatStatus(400,config('permission.constants.messages.fail'));

        return $this->status;
    }
    public function addPermGroup($payload){
        if($this->permissionGroupRepo->addGroupPermission($payload))
            $this->formatStatus(200,config('permission.constants.messages.succ'));
        else
            $this->formatStatus(400,config('permission.constants.messages.failII'));
        
        return $this->status;
    }
    public function getPermissionType($id){
        if(!$this->permissionTypeRepo->getPermisssion($id))
            $this->formatStatus(404,"No Records found");
        else
            $this->formatStatus(200,"",$this->permissionTypeRepo->getPermisssion($id));
        return $this->status;    
    }
    public function getRoleMtx($params){
        if(!$this->permissionTypeRepo->getRoleMtx($params))
            $this->formatStatus(404,"No Records found");
        else
            $this->formatStatus(200,"",$this->permissionTypeRepo->getRoleMtx($params));
        return $this->status;  
    }
    public function removePerm($payload){
        if($this->permissionGroupRepo->remPerm($payload))
            $this->formatStatus(200,config('permission.constants.messages.succ_rem'));
        else
            $this->formatStatus(400,config('permission.constants.messages.fail'));
        return $this->status; 
    }
    public function deleteType($id){
        DB::beginTransaction();
        $perm_id = $this->permissionTypeRepo->delType($id);
        $group = ["permission_type_id"=>$id];
        $this->flag = true;
        if($perm_id){
            if($perm_id instanceof QueryException)
                $this->flag = false;     
            else
                $group = $this->permissionGroupRepo->remPerm($group);
            
            if($this->flag){
                DB::commit();
                $this->formatStatus(200,config('permission.constants.messages.succ_remII'));
            }
            else{
                DB::rollback();
                $this->formatStatus(400,'This Role Has Users');
            }
        }
        else
            $this->formatStatus(400,config('permission.constants.messages.fail'));

        return $this->status; 
        
    }
    
    public function roleAuto($payload){
        if($this->permissionTypeRepo->roleAuto($payload))
            $this->formatStatus(200,'',$this->permissionTypeRepo->roleAuto($payload));
        else
            $this->formatStatus(400,'No Records found');
        return $this->status; 
    }

    public function permAuto($payload){
        if($this->permissionRepo->permAuto($payload))
            $this->formatStatus(200,'',$this->permissionRepo->permAuto($payload));
        else
            $this->formatStatus(400,'No Records found');
        return $this->status; 
    }
}