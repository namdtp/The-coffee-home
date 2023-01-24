<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    public static function sendSms($message, $mobile){
        $APIKey="9DA3EF0C09742019B8C82E4380B6C4";
        $SecretKey="50B41EFCEF4989DBE971112D29DDF6";
        $YourPhone=$mobile;
        $Content=$message;
    
        $SendContent=urlencode($Content);
        $data="http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=$YourPhone&ApiKey=$APIKey&SecretKey=$SecretKey&Content=$SendContent&Brandname=XXXX&SmsType=2";
        //De dang ky brandname rieng vui long lien he hotline 0901.888.484 hoac nhan vien kinh Doanh cua ban
        $curl = curl_init($data); 
        curl_setopt($curl, CURLOPT_FAILONERROR, true); 
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        $result = curl_exec($curl); 
            
        $obj = json_decode($result,true);
        if($obj['CodeResult']==100)
        {
            print "<br>";
            print "CodeResult:".$obj['CodeResult'];
            print "<br>";
            print "CountRegenerate:".$obj['CountRegenerate'];
            print "<br>";     
            print "SMSID:".$obj['SMSID'];
            print "<br>";
        }
        else
        {
            print "ErrorMessage:".$obj['ErrorMessage'];
        }
    }
}
