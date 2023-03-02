<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\{UserProfileRequest,UpdateUserPermission};
use Modules\User\Services\UserService;

class UserController extends Controller
{
    private $userService;
    private $status;

    public function __construct(UserService $userService){

        $this->userService = $userService;
        
    }
    public function index(Request $params)
    {
        
        $this->status = $this->userService->getUsers($params->all());
          return response()->json([
                                    "message" => $this->status['msg'],
                                    "data" => $this->status['data']
                                ],$this->status['code']);

    }
    public function showProfile($user_id)
    {

        $this->status = $this->userService->getUserProfile($user_id);
        return response()->json([
                                    "message" => $this->status['msg'],
                                    "data" => $this->status['data']
                                ],$this->status['code']);

        
    }
    public function updateUserPerm(UpdateUserPermission $request,$user_id)
    {

        $payload = array_merge($request->payload(),['user_id' => $user_id]);
        $this->status = $this->userService->updatePerm($payload);

        return response()->json([
                                    "message" => $this->status['msg'],
                                    "data" => $this->status['data']
                                ],$this->status['code']);

    }
    public function updateProfile(UserProfileRequest $request)
    {

        $payload = $request->payload();
        $user = request()->user();
        $this->status = $this->userService->updateProfile($payload,$user->user_id);

        return response()->json([
                                    "message" => $this->status['msg'],
                                    "data" => $this->status['data']
                                ],$this->status['code']);

    }
    public function destroy($user_id)
    {

        $this->status = $this->userService->deleteUser($user_id);

        return response()->json([
            "message" => $this->status['msg'], 
        ],$this->status['code']);

    }
    public function userAuto(Request $request){
        
        $this->status = $this->userService->userAuto($request['username']);

        return response()->json([
                                    "message" => $this->status['msg'],
                                    "data" => $this->status['data']
                                ],$this->status['code']);

    }
}
