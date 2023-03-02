<?php
namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPermission extends FormRequest{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules(){
    	return  [
            "permission_type_id" => 'required|integer|min:1|exists:permission_type,permission_type_id'
        ]; 
    }
   	public function payload()
    {
        return $this->only([
            'permission_type_id'
        ]);
    }
}