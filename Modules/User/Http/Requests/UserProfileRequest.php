<?php
namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules(){
    	return  [
            'f_name' => 'nullable|regex:/^[a-z0-9 .\-,]+$/i',
            'l_name' => 'nullable|regex:/^[a-z0-9 .\-,]+$/i',
            'contact_number' => 'nullable'
        ]; 
    }
    // preg_match('+?([0-9]{2})-?([0-9]{3})-?([0-9]{6,7})', $phone)
   	public function payload()
    {
        return $this->only([
            'f_name',
            'l_name',
            'contact_number'
        ]);
    }
}