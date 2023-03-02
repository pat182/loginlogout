<?php
namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogInRequest extends FormRequest{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules(){
    	return  [
            'username' => 'required',
            'password' => 'required'
        ]; 
    }
   	public function payload()
    {
        return $this->only([
            "username",
            "password"
        ]);
    }
}