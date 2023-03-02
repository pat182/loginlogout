<?php
namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules(){
        
    	return  [
            'user.username' => 'required|string|between:1,45|unique:user',
            'user.email' => 'required|string|email|max:255|unique:user',
            'user.permission_type_id' => 'required|integer|min:1|exists:permission_type,permission_type_id',
            'user.password' => 'required|string|min:8',
            'user_profile.f_name' => 'nullable|regex:/^[a-z0-9 .\-,]+$/i',
            'user_profile.l_name' => 'nullable|regex:/^[a-z0-9 .\-,]+$/i',

        ]; 
    }
   	public function payload()
    {
        return $this->only([

            "user.username",
            "user.email",
            "user.permission_type_id",
            "user.password",
            "user_profile.f_name",
            "user_profile.l_name",

        ]);
    }
}