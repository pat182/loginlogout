<?php

namespace Modules\Paypal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Paypal\Services\PaypalService;
use Modules\Paypal\Http\Requests\{PayPalCreateOrderRequest,PayPalCaptureOrderRequest};

class PaypalController extends Controller
{
    private $paypalService;
    
    public function __construct(PaypalService $paypalService){
        $this->paypalService = $paypalService;
    }

    public function auth(){

        return $this->paypalService->auth();
        
    }
    public function create(PayPalCreateOrderRequest $req)
    {
        
        return $this->paypalService->createOrder($req->payload());
    
    }
    public function capture(PayPalCaptureOrderRequest $req){

        return $this->paypalService->captureOrder($req->payload());

    }

}
