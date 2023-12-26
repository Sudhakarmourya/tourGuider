<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Setting;

if(!function_exists('randomString')){
    function randomString($strLength){
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890');
        return substr($random, 0, $strLength);
    }
}

if(!function_exists('numberFormat')){
    function numberFormat($number){
        return number_format((float)$number, 2);
    }
}
if(!function_exists('priceFormat')){
    function priceFormat($number){
        return 'Rs. '.numberFormat($number);
    }
}

if(!function_exists('getVersion')){
    function getVersion(){
        return config('app.app_version');
    }
}

if(!function_exists('dateFormat')){
    function dateFormat($date, $time = true){
        if ($time) {
            return date('M d, Y h:i A', strtotime($date));
        }

        return date('M d, Y', strtotime($date));
    }
}

if(!function_exists('returnJsonResponse')){
    function returnJsonResponse($error_code, $message = '', $data = ''){
        $status = false;
        $errors = '';
        if(in_array($error_code, [200, 201, 202, 203, 204])){
            $status = true;
        }elseif(in_array($error_code, [400, 401, 402, 403, 404, 422])){
            $errors  = $error_code == 422 ? $message : '';
            $message = $error_code != 422 ? trans('messages.404') : '';
        }else{
            $message = $message ?: trans('messages.500');
        }

        return response()->json(['data' => $data, 'message' => $message, 'errors' => $errors, 'status' => $status], $error_code);
    }
}

if(!function_exists('validateRequest')){
    function validateRequest(Request $request, $rule, $message = []){
        $validator = Validator::make($request->all(), $rule, $message);
        if($validator->fails()){
            return $validator->errors();
        }else{
            return false;
        }
    }
}

if(!function_exists('getSlug')){
    function getSlug($str){
        return Str::slug($str, '-');
    }
}

if(!function_exists('uploadFiles')){
    function uploadFiles(Request $request, $param, $folder){
        $imageNameArr = [];
        if($request->hasFile($param)){
            if(is_array($request->file($param))){
                foreach($request->file($param) as $file){
                    $imageName = Storage::putFile($folder, $file);
                    array_push($imageNameArr, $imageName);
                }
            }else{
                $imageName = Storage::putFile($folder, $request->file($param));
                array_push($imageNameArr, $imageName);
            }
        }
        return implode(',', $imageNameArr);
    }
}

if(!function_exists('deleteFiles')){
    function deleteFiles($fileName){
        try {
            $fileNameArr = explode(',', $fileName);
            
            foreach ($fileNameArr as $file) {
                if (Storage::exists($file)) {
                    Storage::delete($file);
                }
            }
        } catch (\Exception $e) {
            return returnJsonResponse(500);
        }
    }
}

if(!function_exists('getSettings')){
    function getSettings($slug = null){
        if($slug){
            $data = Setting::where('slug', $slug)->first()->value;
        }else{
            $data = Setting::get();
        }
        return $data;
    }
}

if(!function_exists('displayImage')){
    function displayImage($path){
        $path = $path ? $path : 'demo.jpg';
        return getSettings('public-domain').$path;
    }
}

if (!function_exists('saveData')) {
    function saveData($model_obj, $request, $remove_key = []) {
        foreach ($request->all() as $key => $value) {
            if($key == '_token' || in_array($key, $remove_key))
                continue;
            $model_obj->$key = $value;
        }
        return $model_obj->save();
    }
}


if (!function_exists('hello')) {
    function hello() {
        return "hello akash";
    }
}


if (!function_exists('returnWithError')) {
    function returnWithError($errors) {
        return Redirect::back()->withErrors($errors)->withInput();
    }
}

if (!function_exists('returnSuccess')) {
    function returnSuccess($msg, $path = false) {
        if($path)
            return Redirect::to($path)->with('success', $msg);
        else
            return Redirect::back()->with('success', $msg); 
    }
}

if (!function_exists('returnDanger')) {
    function returnDanger($msg, $path = false) {
        if($path)
            return Redirect::to($path)->with('danger', $msg);
        else
            return Redirect::back()->with('danger', $msg); 
    }
}

// if (!function_exists('showError')) {
//     function showError($key) {
//         // dd($key);
//         // dd($$error)/;
//         return isset($$error) ? $$error->$key : '';
//     }
// }


