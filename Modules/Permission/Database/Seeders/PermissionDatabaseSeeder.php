<?php

namespace Modules\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Permission\Entities\Repositories\PermissionTypeRepository;
use Modules\Permission\Entities\Repositories\PermissionRepository;
use Modules\Permission\Entities\Repositories\PermissionGroupRepository;

class PermissionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Model::unguard();
        $role = (new PermissionTypeRepository())->addPermission('superadmin');
        
        $p = new PermissionRepository();
        $data = [
            [
                'action_description' => 'add user',
                'action' => 'add',
                'method' => 'post',
                'end_point' => 'AuthController@register'        
            ],
            [
                'action_description' => 'update permission',
                'action' => 'update',
                'method' => 'put',
                'end_point' => 'UserController@updateUserPerm'                 
            ],
            [
                'action_description' => 'delete user',
                'action' => 'delete',
                'method' => 'delete',
                'end_point' => 'UserController@destroy'                 
            ]
        ];
        foreach ($data as $value) {
            $permissions = $p->addPermission($value);
            (new PermissionGroupRepository())->addGroupPermission([
                'permission_type_id' => $role,
                'permission_id' => $permissions
            ]);
        }
        (new PermissionTypeRepository())->addPermission('testGroup');
        
    }
}
