<?php

namespace Modules\Paypal\Services;

use GuzzleHttp\Client;
// use Guzzle\Http\Exception\ClientException;
// use Illuminate\Support\Facades\Http;


class PaypalService
{
    
    private $clientId;
    private $clientSecret;
    private $client;

    public function __construct(){
        $this->url = 'https://api-m.sandbox.paypal.com/';
        $this->client = new Client([
            'base_uri' => $this->url
        ]);
        $this->clientId = config('paypal.client_id');
        $this->clientSecret = config('paypal.client_secret');
        
        
    }

    public function auth(){
        try{
            $auth = $this->client->request('POST','v1/oauth2/token',[
                'auth'=> [
                    $this->clientId,
                    $this->clientSecret
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials'
                ]

            ]);
        }catch(\Exception $e){
            
            return json_decode($e->getResponse()->getbody()->getContents(),true);
    
        }
        return json_decode($auth->getBody()->getContents(),true);
        
    }

    public function createOrder($params){
        
        try{
            
            $order = $this->client->request('POST', 'v2/checkout/orders', [
                
                'headers' => [
                    "Authorization" => $params['paypal_auth'],
                    "Content-Type" => 'application/json',
                    "PayPal-Request-Id" => static::generateRandomString()
                ],
                'body' => json_encode(static::setOrderParameters($params))
            ]);

        }catch(\Exception $e){
            
            return json_decode($e->getResponse()->getbody()->getContents(),true);

        }
        
        return json_decode($order->getBody()->getContents(),true);
        
    }

    public function captureOrder($params){

        try{

            $capture = $this->client->request('POST', 
                "v2/checkout/orders/{$params['order_id']}/capture",[
                'headers' => [
                        "Authorization" => $params['paypal_auth'],
                        "Content-Type" => 'application/json',
                        "PayPal-Request-Id" => 'test'
                ],
            ]);
        }catch(\Exception $e){

             return json_decode($e->getResponse()->getbody()->getContents(),true);

        }

        return json_decode($capture->getBody()->getContents(),true);

    }

    private function setOrderParameters($params){
        
        return [
            "intent" => 'CAPTURE',
            "purchase_units" => [
                [
                    "reference_id" => "d9f80740-38f0-11e8-b467-0ed5f89f718b",
                    "amount" =>[
                        "currency_code" => $params['currency_code'],
                        "value" => $params['amount']
                    ]
                ]
            ],
            "payment_source" => [
                "paypal" => [
                    "experience_context" => [
                        "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
                        "payment_method_selected" => "PAYPAL",
                        "brand_name" => $params['brand_name'],
                        "locale" => "en-US",
                        "landing_page" => "LOGIN",
                        "shipping_preference" => "SET_PROVIDED_ADDRESS",
                        "user_action" => "PAY_NOW",
                        "return_url" => "https://example.com/returnUrl",
                        "cancel_url" => "https://example.com/cancelUrl"
                    ]
                ]
            ]
        ];
        
    }
    private function generateRandomString($length = 10) {

        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
}