<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Place;
use App\Models\Guider;

class CityController extends Controller
{
    public function addCity(Request $request){
        try{
            if($request->isMethod('POST')){
                $rule = [
                    'image' => 'required',
                    'cityname' => 'required'
                ];

                if($validate = validateRequest($request, $rule)){
                    return $validate;
                }else{
                    $poster_image = uploadFiles($request, 'image', 'image');
                    $city = new City;
                    $city->image = $poster_image;
                    $city->cityname = $request->cityname;
                    $city->save();
                    return returnJsonResponse(200,'City Added Successfully');
                }
            }else{
                $data = City::all();
                return $data;
            }

        }catch(\Exception $e){
            return returnJsonResponse(500,$e);
        }
    }

    public function updateCity(Request $request){
        try{
            if($request->isMethod('POST')){
                $rule = [
                    'image' => 'required',
                    'cityname' => 'required'
                ];

                if($validate = validateRequest($request, $rule)){
                    return $validate;
                }else{
                    $poster_image = uploadFiles($request, 'image', 'image');
                    $city = City::find($request->id);
                    $city->image = $poster_image;
                    $city->cityname = $request->cityname;
                    $city->save();
                    return returnJsonResponse(200,'City Added Successfully');
                }
            }else{
                $data = City::find($request->id);
                return $data;
            }

        }catch(\Exception $e){
            return returnJsonResponse(500,$e);
        }
    }


    public function deleteData(Request $request){
        try{
            if($request->id){
                City::where('id',$request->id)->delete();
                return returnJsonResponse(200,'City Deleted Successfully');
            }elseif($request->pid){
                Place::where('id',$request->pid)->delete();
                return returnJsonResponse(200,'Place Deleted Successfully');
            }elseif($request->gid){
                Guider::where('id',$request->gid)->delete();
                return returnJsonResponse(200,'Guider Deleted Successfully'); 
            }
        }catch(\Exception $e){
            return returnJsonResponse(500,$e); 
        }
    }

    public function addPlace(Request $request){
        try{
            if($request->isMethod('POST')){
                $rule = [
                    'placetitle' => 'required',
                    'bestofplace' => 'required',
                    'description' => 'required',
                    'picture' => 'required',
                    'city' => 'required'
                ];

                if($validate = validateRequest($request, $rule)){
                    return $validate;
                }else{
                    $cid  = City::where('cityname',$request->city)->first();
                    $poster_image = uploadFiles($request, 'picture', 'picture');
                    $city = new Place;
                    $city->picture = $poster_image;
                    $city->placetitle = $request->placetitle;
                    $city->bestofplace = $request->bestofplace;
                    $city->description = $request->description;
                    $city->c_id = $cid->id;
                    $city->save();
                    return returnJsonResponse(200,'Place Added Successfully');
                }
            }else{
                $data = Place::all();
                return $data;
            }

        }catch(\Exception $e){
            return returnJsonResponse(500,$e);
        }
    }

    public function updatePlace(Request $request){
        try{
            if($request->isMethod('POST')){
                $rule = [
                    'placetitle' => 'required',
                    'bestofplace' => 'required',
                    'description' => 'required',
                    'picture' => 'required',
                    'city' => 'required'
                ];

                if($validate = validateRequest($request, $rule)){
                    return $validate;
                }else{
                    $cid  = City::where('cityname',$request->city)->first();
                    $poster_image = uploadFiles($request, 'picture', 'picture');
                    $city = Place::find($request->id);
                    $city->picture = $poster_image;
                    $city->placetitle = $request->placetitle;
                    $city->bestofplace = $request->bestofplace;
                    $city->description = $request->description;
                    $city->c_id = $cid->id;
                    $city->save();
                    return returnJsonResponse(200,'Place Updated Successfully');
                }
            }else{
                $data = Place::find($request->id);
                return $data;
            }

        }catch(\Exception $e){
            return returnJsonResponse(500,$e);
        }
    }

    public function addGuider(Request $request){
        try{
            if($request->isMethod('POST')){
                $rule = [
                    'gname' => 'required',
                    'gemail' => 'required|email',
                    'gphone' => 'required',
                    'ggender' => 'required',
                    'gid_proof' => 'required',
                    'gid_number' => 'required',
                    'gqualification' => 'required',
                    'gaddress' => 'required'
                ];

                if($validate = validateRequest($request, $rule)){
                    return $validate;
                }else{
                    $poster_image = uploadFiles($request, 'gid_proof', 'gid_proof');
                    $city = new Guider;
                    $city->gid_proof = $poster_image;
                    $city->gname = $request->gname;
                    $city->gemail = $request->gemail;
                    $city->gphone = $request->gphone;
                    $city->ggender = $request->ggender;
                    $city->gid_number = $request->gid_number;
                    $city->gqualification = $request->gqualification;
                    $city->gaddress = $request->gaddress;
                    $city->save();
                    return returnJsonResponse(200,'Place Added Successfully');
                }
            }else{
                $data = Guider::all();
                return $data;
            }

        }catch(\Exception $e){
            return returnJsonResponse(500,$e);
        }
    }

    public function updateGuider(Request $request){
        try{
            if($request->isMethod('POST')){
                $rule = [
                    'gname' => 'required',
                    'gemail' => 'required|email',
                    'gphone' => 'required',
                    'ggender' => 'required',
                    'gid_proof' => 'required',
                    'gid_number' => 'required',
                    'gqualification' => 'required',
                    'gaddress' => 'required'
                ];

                if($validate = validateRequest($request, $rule)){
                    return $validate;
                }else{
                    $poster_image = uploadFiles($request, 'gid_proof', 'gid_proof');
                    $city = Guider::find($request->id);
                    $city->gid_proof = $poster_image;
                    $city->gname = $request->gname;
                    $city->gemail = $request->gemail;
                    $city->gphone = $request->gphone;
                    $city->ggender = $request->ggender;
                    $city->gid_number = $request->gid_number;
                    $city->gqualification = $request->gqualification;
                    $city->gaddress = $request->gaddress;
                    $city->save();
                    return returnJsonResponse(200,'Guider Updated Successfully');
                }
            }else{
                $data = Guider::find($request->id);
                return $data;
            }

        }catch(\Exception $e){
            return returnJsonResponse(500,$e);
        }
    }
}
