<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageRequest;


class ImageController extends Controller
{
    // 上传图片
    public function upload(ImageRequest $request)
    {
        $today = \Illuminate\Support\Carbon::today()->format('Y-m-d');

        $imageUrl = Storage::disk('uploads')->put('/' . $today, $request->file('image'));
        return $this->success(['url'=> $imageUrl]);
    }

    // 删除图片
    public function titleDelete(ImageRequest $request)
    {
        $status = Storage::disk('uploads')->delete($request->image);
        if($status){
            return $this->message('图片删除成功！');
        }
        return $this->failed('图片删除失败！');
    }

    // 删除图片
    public function delete(ImageRequest $request)
    {
        $imageurl = $request->image[0];
        $image = str_replace(config('app.url') . '/img_backend', '', $imageurl);
        $status = Storage::disk('uploads')->delete($image);
        if($status){
            return $this->message('图片删除成功！');
        }
        return $this->failed('图片删除失败！');
    }
}
