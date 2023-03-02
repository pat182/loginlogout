<?php

namespace Modules\User\Entities\Repositories;

use Modules\User\Entities\User;


class UserRepository extends User
{
    private function getAll($params = null){

        $query = self::select('*')->where($params);
        return $query;
        
    }
    private function getUser($user_id){

        return $this->where('user_id',$user_id);

    }
    public function show($user_id){

        return $this->getUser($user_id);

    }
    public function deleteUser($user_id){

        $user = $this->getUser($user_id)->first();
        if($user)

            $user->delete();

        else

            $user = null;

        return $user;

    }
    public function updatePerm($data){

        $user = $this->getUser($data['user_id']);

        if($user->update(['permission_type_id' => $data["permission_type_id"]]))

           $user = $user->first();

        else

            $user = null;

        return $user;
    }
    public function getAllUser($params){

        $permissionId = auth()->user()->permission_type_id;
        $query = $this->getAll($params)->where(function($q) use ($permissionId){
            if($permissionId != 1){
                $q->AdminUsers();
            }
        });

        return $query->with([
                            'userProfile:user_id,f_name,l_name',
                            'permissionType.permissionGroup.permissionRole:permission_id,action_description,action,method'
                        ])->get();

    }
    // public function getUsersNoSuA($params){

    //     $permissionId = auth()->user()->permission_type_id;
    //     $query = $this->getAll($params)->where(function($q) use ($permissionId){
    //         if($permissionId == 1){

    //         }
    //     });
    // }
    
    public function getUserProfile($id){
        $query = $this->getUser($id);

        return $query->with([
                'userProfile:user_id,f_name,l_name',
                            'permissionType.permissionGroup.permissionRole:permission_id,action_description,action,method',
        ])->first();

    }
}