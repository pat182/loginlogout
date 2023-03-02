<?php

namespace Modules\User\Entities;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Permission\Entities\Repositories\PermissionTypeRepository;
use Modules\User\Entities\Repositories\UserProfileRepository;

class User extends Authenticatable implements JWTSubject
{
    // use HasFactory;
    use Notifiable;

    protected $table = 'user';

    protected $primaryKey = 'user_id';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'username',
        'email',
        'password',
        'permission_type_id'
    ];
    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'password',
        'remember_token'
    ];
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
    * Return a key value array, containing any custom claims to be added to the JWT.
    *
    * @return array
    */
    public function getJWTCustomClaims(){
        return [];
    }
    public function permissionType(){
        return $this->hasOne(PermissionTypeRepository::class,'permission_type_id','permission_type_id');
    }
    public function userProfile(){
        return $this->hasOne(UserProfileRepository::class,'user_id');
    }
    
    public function filterRoles(){

        return static::select('permission_type_id')->with([
            'permissionType:permission_type_id',
            'permissionType.permissionGroup.permissionRole:permission_id,end_point'
        ])->where('user_id',$this->user_id);

    }
    public function scopeAdminUsers($query){

        return $query->where('permission_type_id', '<>' ,1);

    }
    // protected static function newFactory()
    // {
    //     return \Modules\User\Database\factories\UserFactory::new();
    // }
}
