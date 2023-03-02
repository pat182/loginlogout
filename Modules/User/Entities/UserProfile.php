<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\Repositories\UserRepository;

class UserProfile extends Model
{
    // use HasFactory;
    protected $table = 'user_profile';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'f_name',
        'l_name',
    ];
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    // public $timestamps = false;
    public function userA(){
        return $this->hasOne(UserRepository::class,'user_id');
    }
    // protected static function newFactory()
    // {
    //     return \Modules\User\Database\factories\UserProfileFactory::new();
    // }
}
