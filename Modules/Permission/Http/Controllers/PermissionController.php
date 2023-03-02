<?php

namespace Modules\Permission\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Permission\Http\Requests\{PermissionTypeRequest,PermissionRequest,PermissionGroupRequest};
use Modules\Permission\Services\PermissionService;


class PermissionController extends Controller
{
    private $permissionService;
    private $status;

    public function __construct(PermissionService $permissionService){
        $this->permissionService = $permissionService;
    }
    public function index(Request $params){
        $this->status = $this->permissionService->getRoleMtx($params->all());
                return response()->json([
                                    "data" => $this->status['data']
                                ],$this->status["code"]);
    }
    public function show($perm_id){
        $this->status = $this->permissionService->getPermissionType($perm_id);
        return response()->json([
                                    "data" => $this->status['data']
                                ],$this->status["code"]);
    }
    public function create(PermissionRequest $request){
        $payload = $request->payload();
        $this->status = $this->permissionService->addPerm($payload);
        return response()->json([
                                    "message" => $this->status['msg']
                                ],$this->status["code"]);
    }
    public function addPermGroup(PermissionGroupRequest $request){
        $payload = $request->payload();
        $this->status = $this->permissionService->addPermGroup($payload);
        return response()->json([
                                    'message' => $this->status['msg']
                                ],$this->status["code"]);
    }
    public function addType(PermissionTypeRequest $request){

        $payload = $request->payload();
        $this->status = $this->permissionService->addPermType($payload);
        return response()->json([
                                    'message' => $this->status['msg']
                                ],$this->status["code"]);
        
    }
    public function removePermission(PermissionGroupRequest $request){
        $payload = $request->payload();
        $this->status = $this->permissionService->removePerm($payload);
        return response()->json([
                                    'message' => $this->status['msg']
                            ],$this->status["code"]);
    }
    public function roleAuto(Request $request){
        
        $payload = $request['permission'];
        $this->status = $this->permissionService->roleAuto($payload);

        return response()->json([
                                    "message" => $this->status['msg'],
                                    "data" => $this->status['data']
                                ],$this->status["code"]);
    }
    public function permAuto(Request $request){
        $payload = $request['permission'];
        $this->status = $this->permissionService->permAuto($payload);
        
        return response()->json([
                                    "message" => $this->status['msg'],
                                    "data" => $this->status['data']
                                ],$this->status["code"]);
    }
    public function deleteType($type_id){
        $this->status = $this->permissionService->deleteType($type_id);

        return response()->json([
                                    "message" => $this->status['msg'],
                                    "data" => $this->status['data']
                                ],$this->status["code"]);
    }
}
