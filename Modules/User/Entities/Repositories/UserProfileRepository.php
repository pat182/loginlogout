<?php

namespace Modules\User\Entities\Repositories;

// use Modules\User\Entities\User;
use Modules\User\Entities\UserProfile;
use Modules\User\Entities\Repositories\UserRepository;

class UserProfileRepository extends UserProfile
{

    private function getUpdatable($id){
        return $this->where('id',$id)->first();
    }
    private function getAll($params = null){
        $query = self::select('*')->where($params);
        return $query;
    }
    public function updateProfile($payload){
        $user = $this->getUpdatable($payload['user_id']);
        if($user)
            $user->update($payload);  
        return $user;
    }
    public function deleteProfile($user){
        if($user){
            $profile = $user->userProfile;
            if($profile)
                $profile->delete();
        }else
            $profile = null;
        
        
        return $profile;
    }
    public function userAuto($string){
        $permissionId = auth()->user()->permission_type_id;
        $query = $this->getAll()
        ->where('f_name','LIKE',  $string . '%')
        ->orWhere('l_name','LIKE',  $string . '%')
        ->with(['userA' => function($qry) use ($permissionId){
            if($permissionId != 1){
                
                $qry->AdminUsers();
                
            }
        }])->get();
        if(count($query))
            $data = $query;
        else
            $data = null;
        return $data;
    }

}