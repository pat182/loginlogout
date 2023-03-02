<?php

namespace Modules\Paypal\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Paypal\Services\PaypalService;

class PaypalMiddleware
{
    private $paypalService;
    
    public function __construct(PaypalService $paypalService){
        $this->paypalService = $paypalService;
    }

    
    public function handle(Request $request,Closure $next)
    {
        // $this->paypalService->auth();
        // try{
        //     dd($this->paypalService->auth());
        // }catch(\Exception $e){
        //     // dd('asdasd');
        //     return $this->paypalService->auth();
        // }
        

        return $next($request);
    }

}
