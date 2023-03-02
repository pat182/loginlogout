<?php 

namespace Modules\Permission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules(){
    	return [
    		"action_description" => 'required',
    		"action" => 'required|string|min:3|max:7',
    		"method" => 'required|string|min:3|max:7'
    	]; 
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
   	public function payload()
    {
        return $this->only([
            "action_description",
            "action",
            "method",
            "end_point"
        ]);
    }
}