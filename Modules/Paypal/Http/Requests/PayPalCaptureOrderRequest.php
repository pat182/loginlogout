<?php
namespace Modules\Paypal\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayPalCaptureOrderRequest extends FormRequest{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules(){
        
    	return  [
            "paypal_auth" => "required",
            "order_id" => "required",
            
        ];

    }
   	public function payload()
    {
        return $this->only([

           "paypal_auth",
           "order_id"

        ]);
    }
}