<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\Request;
use App\Http\Requests\AdRequest;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class WechatController extends Controller
{
    private $token = "yumancang";

    private function checkSignature($request)
    {
        $signature = $request->signature;
        $timestamp = $request->timestamp;
        $nonce = $request->nonce;

        $token = $this->token;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    public function yfsailAction(Request $request)
    {
        $postStr = file_get_contents("php://input", 'r');
        Log::channel('zip')->info("php://input " . $postStr);
        $post = $request->post();
        Log::channel('zip')->info("post " . json_encode($post));
        $fullUrl = $request->fullUrl();
        Log::channel('zip')->info("fullUrl " . $fullUrl);
        if ($this->checkSignature($request)) {
            echo $request->echostr;
            exit();
        }
        /*$xmlstr = <<<XML
            <xml>
            <ToUserName><![CDATA[gh_0b101caa73f1]]></ToUserName>
            <FromUserName><![CDATA[oaw1Ww-8pJlD9IT_xxrr0Oj5oGjY]]></FromUserName>
            <CreateTime>1584800564</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[125]]></Content>
            <MsgId>22688890431965327</MsgId>
            </xml>
XML;
        $xml = simplexml_load_string($xmlstr);

        foreach($xml->children() as $child)
        {
            dd($child->__toString());
            echo $child->getName() . ": " . $child . "<br>";
        }
        dd($xml->ToUserName[0]);
        foreach ($xml->children() as $child)
        {
            echo $child->getName() . "\n";
        }
        dd($xml->children()->getName('ToUserName'));
        $movies = new \SimpleXMLElement($xmlstr);
        dd($movies->ToUserName);*/
        echo 123;exit();

    }

    public function blogAction(Request $request)
    {
        $postStr = file_get_contents("php://input", 'r');
        Log::channel('zip')->info("php://input " . $postStr);
        $post = $request->post();
        Log::channel('zip')->info("post " . json_encode($post));
        $fullUrl = $request->fullUrl();
        Log::channel('zip')->info("fullUrl " . $fullUrl);
        if ($this->checkSignature($request)) {
            echo $request->echostr;
            exit();
        }
        echo 123;exit();
    }
}
