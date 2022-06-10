<?php
namespace App\Traits;


use App\Models\SiteSetting;
use Illuminate\Support\Facades\Auth;

trait Sms
{
    function sendSms($contact,$msg) {

        $url = "https://gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2";
        $data = [
            "username" => "Londonas",
            "password" => "{2018L@n",
            "apicode" => "1",
            "msisdn" => $contact,
            "countrycode" => "880",
            "cli" => "2222",
            "messagetype" => "1",
            "message" => $msg,
            "messageid" => "0"
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}




