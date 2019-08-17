<?php

namespace App\Http\Controllers;

use Yansongda\Pay\Pay;
use Illuminate\Http\Request;

class PayController extends Controller
{
     public function __construct()
    {
       $this->middleware('pay:api', ['except' => ['notify','return']]);
        //构造函数，过滤login
    }

    protected $config = [
        'alipay' => [
            'app_id' => '2016100100641562',

            'notify_url' => 'http://localhost/laravel/blog/public/api/auth/notify',
            'return_url' => 'http://localhost/laravel/blog/public/api/auth/return',


            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnUB8vuoBvlDWdp24EehXiyRSlCijKxngVOWsD855qSgNY5MVz30amlHmZljqUIpuRlCCER2o+G+Rf85+wetrzt1xdG4sqnU6/VaJ1Op7CnRTvSDZXKwU7e35rGwmxerAahixzVyDWZ+Ura8n4/0FtWGL/arzP5CFqH7sK7QZbxgGHiw43H1OYfwAWeIwDDBzeKYGIZwagau6h0sORe7DgGlSuVOURHKla6GeQO/ErpdMKsWsuk4goXhh2Q1TUszsxzB1RL+d71ZyA3zox6XCh9lPY8qbWOabZhZKo9++UEgWdhA0zdTQ9g1SHzVj+hHIpV3pALfaqxeGTShOnFMeywIDAQAB',

            'private_key' => 'MIIEogIBAAKCAQEAwrJC9UDX0W4mzABobdPG91RLLaRQCIu1OKxOlGaH0yLF7Ry04nMKVUTNbcpbW8OwpgYx5Bg66u4W5/vEQCfXNZ4PQD24iEh1U/llG2VnmGLxFT7/4g6R7SP5ecZyDf29nHdvqgCaR/8i5y/se0tvOey03f7qG1tH2cxyfQ6v183DX8iEwm+lU3BIVz7wtR3eadmfaDEqRobxz+uReALXum4aRgY9nk7CETdfoN4D7o2f/PJVIjLGgQzgsaT4URZrYitMbRNjJUChcDvJ7Gqr3lufhMdsot8JwVwhul0u8F/hocDeNuLVm4srwktvt+Mw2PBk2cMXmlE1ybmUvpiHUwIDAQABAoIBAHE0aU5lB5fUbmaLjizdyICi2JuPQKHXaeWr+ny7KRqQy3jVCi/pKAbwXGoMERbIL/w4+eVgWVGkYlk8wJ11DOM2JjP6L0O+rcnH5wwI6DVowjjSSsJMKnkyQ6qUwlh0Qz2pDJpSg2J9bPPzn5MJB4EsqvWxdLm3V43CHIeudHwLObJuobqCLq20nglWMXPe+xW0bABqQm8M3ncumCUKkdKzEiRzlzgtiwHLChNLb16A5LjUPGTQiqHTJXJrDDmxLPwlrox33RTrRWA7AQMlko9nr2/zEQ8/c2a+2AZjY0XWeHKpL67vtotDH8VN/tu1YZlO5KH350/GaS631O64ylECgYEA8ZIbB/8XducX6EPMB4kDglU58bDFOGQJ6nCHknIkFTO4UzQ4tuArl01WtbJx2wcKIvU7TslaBiuwlt4Kygohp63echWL3Fisi/GzCZi7xIuWGyHgHV18RIZCPI6Frvy+DhVaz/4/PFFst+LTk8XYRXv5R12FxnWgoL/CpLOPJQ8CgYEAzlNkgDVgzKYSZrop64lfyqR5naQjkl8S1REvTc1FpgT9rrnx/pF/RxfXEjv+NPUAdreMUPpltthTHckeY4GmQ/9q5D5Oj2EuNWwLHUp9KizhOvkvIgCaOxCnj7Vuto/GpzAbmm1d5S8gutcPB1+PPmhejCdOQF0YyXWb0NBLoX0CgYBhQmPjuk6mLrCvcOxqdD2XcdzcdEFTTOO5IglTauUgLCygQzw6VNL4Hck1alzwxErOfFGejO7T4S897rQFWELokdYntIkU9Ba0WWGuEXI31cNftSnYaNUpeaydWPx10YhrfymK6GBpVpchChAJRPSoNRvOIddEagN79PjW+vw8/QKBgBEixe8L/90fUdnsTjz8rNMEtAEOt9GZSdQeWEJq8QTn1zXixaFx7hM2fKtMBkHZs08o0WOMWFRGRSjtIjP7eZaeKP+J2TZ5SMAxF/83x4twLMicF3kIeca8DF6YH/jTmhkamsBJowm8z0gVQm9HVXtGacvUG+Cmmr9ooCdIlW91AoGAQv1HWMXIMyyNBIJkrP+3sUyMQzqmhRzPsTVJ4Zlyag7HdK8jp8BYzD+f0+u3nZIRD4H2ztzAwHsRbdL143U4r0SH75xzRFO729MUg5to7bf3xTzLahuoqEOBHZxEcR+iNVNqhgAw9JkQwrXu/SJTL1lKm4M3zdOzUNJY5LWgdtg=',
        ],
    ];

    public function index(Request $request)
    {
        $config_biz = [
            'out_trade_no' => $request->input('oid'),
            'total_amount' => '1000000',
            'subject'      => 'test subject',
        ];
        $pay = new Pay($this->config);
        return $pay->driver('alipay')->gateway()->pay($config_biz);
    }

    public function return(Request $request)
    {
        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->verify($request->all());
        header("location:http//localhost:8080/#/buyca");
    }

    public function notify(Request $request)
    {
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->all())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。 
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号； 
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）； 
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）； 
            // 4、验证app_id是否为该商户本身。 
            // 5、其它业务逻辑情况
            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}