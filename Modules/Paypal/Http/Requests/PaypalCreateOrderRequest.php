<?php
namespace Modules\Paypal\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayPalCreateOrderRequest extends FormRequest{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules(){
        
    	return  [
            "paypal_auth" => "required",
            "amount" => "required",
            "currency_code" => "required",
            "brand_name" => "required"
        ]; 
    }
   	public function payload()
    {
        return $this->only([

           "paypal_auth",
           "amount",
           "currency_code",
           "brand_name"

        ]);
    }
}