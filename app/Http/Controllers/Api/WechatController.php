<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use Illuminate\Http\Request;
use App\Http\Requests\AdRequest;
use Illuminate\Support\Facades\Log;

class WechatController extends Controller
{
    public function indexAction(Request $request)
    {
        $data = $request->all();
        Log::channel('zip')->info(json_encode($data));
        echo 123123;
    }
}
