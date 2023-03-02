<?php

namespace Modules\User\Services;

use Modules\User\Entities\Repositories\UserRepository;
use Modules\User\Entities\Repositories\UserProfileRepository;
use App\Notifications\SuccessRegNotification;
use Illuminate\Support\Facades\DB;

class UserService
{
    private $userRepository;
    private $profileRepository;
    protected $status;

    public function __construct(UserRepository $userRepository, UserProfileRepository $profileRepository)
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
        
    }
    protected function formatStatus($code,$msg, $data=null):void{
        $this->status["code"] = $code;
        $this->status["msg"] = $msg;
        if($data)
            $this->status["data"] = is_array($data) ? $data : $data->toArray();
        else
            $this->status["data"] = [];
        
    }
    public function sendEmailReg($user)
    {

        $user->notify(new SuccessRegNotification());
        
    }
    public function updateProfile($payload,$user_id){

        $payload = array_merge($payload, ['user_id' => $user_id]);

        if($this->profileRepository->updateProfile($payload))

            $this->formatStatus(200,config('user.constants.messages.succ'),$this->profileRepository->updateProfile($payload));

        else

            $this->formatStatus(400,config('user.constants.messages.fail'));   

        return $this->status
        ;
    }

    public function deleteUser($user_id){
        DB::beginTransaction();

        $profile = $this->profileRepository->deleteProfile($this->userRepository->show($user_id)->first());
        $user = $this->userRepository->deleteUser($user_id);

        if($profile && $user){

            DB::commit();
            $this->formatStatus(200,config('user.constants.messages.succ-del'));

        }else{

            DB::rollback();
            $this->formatStatus(400,config('user.constants.messages.fail')); 

        }

        return $this->status;
    }

    public function updatePerm($payload){

        $user = $this->userRepository->updatePerm($payload);

        if($user)

            $this->formatStatus(200,config('user.constants.messages.suc-perm'),$user);

        else

            $this->formatStatus(400,config('user.constants.messages.fail'));

        return $this->status;
    }
    public function getUsers($params){

        // dd(auth()->user());
        $users = $this->userRepository->getAllUser($params);

        if(count($users))

            $this->formatStatus(200,'',$users);

        else

            $this->formatStatus(404,"No Records found");

        return $this->status;
    }
    public function getUserProfile($id){

        $user = $this->userRepository->getUserProfile($id);
        if($user)

            $this->formatStatus(200,'',$user);

        else

            $this->formatStatus(404,'No Records found');

        return $this->status;

    }
    public function userAuto($string){

        if($data = $this->profileRepository->userAuto($string))
            $this->formatStatus(200,'',$data);
        else
            $this->formatStatus(404,'No Records found');
        return $this->status; 
    }
}
