<?php

namespace App\Http\Controllers\Api;

use App\Events\GoodsCancelEvent;
use App\Models\Ad;
use EasyWeChat\Factory;
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

    public function oauthCallAction(Request $request)
    {
        $app = Factory::officialAccount(config('wechat'));
        $oauth = $app->oauth;

        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        prend($user);
        $_SESSION['wechat_user'] = $user->toArray();

        $targetUrl = empty($_SESSION['target_url']) ? '/' : $_SESSION['target_url'];

        header('location:'. $targetUrl); // 跳转到 user/profile

    }


    public function oauthAction(Request $request)
    {
        $app = Factory::officialAccount(config('wechat'));
        $response = $app->oauth->scopes(['snsapi_userinfo'])
            ->setRequest($request)
            ->redirect();
        return $response;

    }

    public function blogAction(Request $request)
    {
        $postStr = file_get_contents("php://input", 'r');
        Log::channel('zip')->info("php://input " . $postStr);
        $post = $request->post();
        Log::channel('zip')->info("post " . json_encode($post));
        $fullUrl = $request->fullUrl();
        Log::channel('zip')->info("fullUrl " . $fullUrl);

        $app = Factory::officialAccount(config('wechat'));
        $app->server->push(function ($message) {
            prend($message);
            return "您好！欢迎关注我!";
        });

        $response = $app->server->serve();

        return $response;

// 将响应输出
        $response->send();exit; // Laravel 里请使用：return $response;


        /*if ($this->checkSignature($request)) {
            echo $request->echostr;
            exit();
        }*/

        $postStr1 = <<<XML
            <xml><ToUserName><![CDATA[gh_b7eacfcd3a7e]]></ToUserName>
<FromUserName><![CDATA[ojdRHwx26-p1bY41vocOi-bRJ-Y8]]></FromUserName>
<CreateTime>1584859714</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<PicUrl><![CDATA[http://mmbiz.qpic.cn/mmbiz_jpg/X3Qw0OS9GGKRffI8Cc93Oh21icX4cnm0Cz4JrDibQrmWycWBEdQ5ETHJZsJjQoydEiaibFeeBHujXe95XYvMmpk4Xg/0]]></PicUrl>
<MsgId>22689734219928657</MsgId>
<MediaId><![CDATA[6-nSpdT7dau0zBKiSLnuuyYSd22q6K6Ldht4Y4Y-LgHwin0ggGpoxNIy9zz0hUfe]]></MediaId>
</xml>
XML;
        $xml = simplexml_load_string($postStr);
        $msgType = $this->getMsgType($xml);
        switch ($msgType) {
            case 'text':
                echo $this->replyText($xml);
                exit();
            case 'image':
                echo $this->replyImage($xml);
                exit();
                break;
        }
        foreach($xml->children() as $child)
        {
            dd($child->__toString());
            echo $child->getName() . ": " . $child . "<br>";
        }
        echo 123;exit();
    }

    public function getToUserName($xml)
    {
        $toUser = $xml->ToUserName[0]->__toString();
        return $toUser;
    }

    public function getFromUserName($xml)
    {
        $fromUser = $xml->FromUserName[0]->__toString();
        return $fromUser;
    }

    public function getMsgType($xml)
    {
        $msgType = $xml->MsgType[0]->__toString();
        return $msgType;
    }

    public function getContent($xml)
    {
        $content = $xml->Content[0]->__toString();
        return $content;
    }

    public function getCreateTime($xml)
    {
        $time = $xml->CreateTime[0]->__toString();
        return $time;
    }

    public function getPicUrl($xml)
    {
        $time = $xml->PicUrl[0]->__toString();
        return $time;
    }

    public function getMediaId($xml)
    {
        $time = $xml->MediaId[0]->__toString();
        return $time;
    }

    public function getTextMessageTemplate()
    {
        $xmlstr = <<<XML
            <xml>
  <ToUserName><![CDATA[#toUser#]]></ToUserName>
  <FromUserName><![CDATA[#fromUser#]]></FromUserName>
  <CreateTime>#time#</CreateTime>
  <MsgType><![CDATA[#msgType#]]></MsgType>
  <Content><![CDATA[#content#]]></Content>
</xml>
XML;
        return $xmlstr;
    }

    public function getImageMessageTemplate()
    {
        $xmlstr = <<<XML
            <xml>
  <ToUserName><![CDATA[#toUser#]]></ToUserName>
  <FromUserName><![CDATA[#fromUser#]]></FromUserName>
  <CreateTime>#time#</CreateTime>
  <MsgType><![CDATA[#msgType#]]></MsgType>
  <Image>
    <MediaId><![CDATA[#media_id#]]></MediaId>
  </Image>
</xml>
XML;
        return $xmlstr;
    }

    public function replyText($xml)
    {
        $toUser = $this->getToUserName($xml);
        $fromUser = $this->getFromUserName($xml);
        $msgType = $this->getMsgType($xml);
        $content = $this->getContent($xml);
        $xmlStr = $this->getTextMessageTemplate();
        $xmlStr = str_replace([
            '#toUser#',
            '#fromUser#',
            '#time#',
            '#msgType#',
            '#content#',
        ], [$fromUser, $toUser, time(), $msgType, $content . ' 你在说什么大声点听不见'], $xmlStr);
        return $xmlStr;
    }

    public function replyImage($xml)
    {
        $toUser = $this->getToUserName($xml);
        $fromUser = $this->getFromUserName($xml);
        $msgType = $this->getMsgType($xml);
        $PicUrl = $this->getPicUrl($xml);
        $MediaId = $this->getMediaId($xml);
        $xmlStr = $this->getImageMessageTemplate();
        $xmlStr = str_replace([
            '#toUser#',
            '#fromUser#',
            '#time#',
            '#msgType#',
            '#media_id#',
        ], [$fromUser, $toUser, time(), $msgType, $MediaId], $xmlStr);
        return $xmlStr;
    }
}
