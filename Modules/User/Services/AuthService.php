<?php

namespace Modules\User\Services;

use JWTAuth;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\Repositories\UserRepository;
// use App\Console\Socket;

class AuthService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login($request)
    {
        // to invalidate the concurrent user
        if (!JWTAuth::attempt($request)){
            return response()->json(['error'=>'Invalid Credentials'],400);
        }
        

        $user = $this->userRepository->show(Auth::id())->first();
        return $this->createToken($user);
    }
    private function createToken($user){
        $token = auth()->setTTL(50000000)->login($user);
        // Socket::BrodCast(['username' => $user->username,'action' => 'login']);
        $ttl = auth('api')->factory()->getTTL() * 60;
        return [
            'user_id' => $user->user_id,
            'user' => $user->username,
            "permission_type_id" => $user->permission_type_id,
            'permission_type' => $user->permissionType->permission,
            'permissions' => $user->filterRoles()->first()->toArray()['permission_type']['permission_group'],
            'token' => $token,
            'expires_in' => $ttl,
            'expires_at' => Carbon::now()->addMinutes(intval($ttl))->toDateTimeString()
        ];
    }
}
