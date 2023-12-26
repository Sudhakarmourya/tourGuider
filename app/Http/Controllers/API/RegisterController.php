<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use ValidationException;

class RegisterController extends Controller
{
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }


    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
    
    public function register(Request $request)
    {
        $rule = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'rashi' => 'required',
            'image' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ];
   
        if($validate = validateRequest($request, $rule)){
            return $validate;
        }else{
            $poster_image = uploadFiles($request, 'image', 'image');
            $input = Hash::make($request->password);
            $user = new User;
            $user->image = $poster_image;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->rashi = $request->rashi;
            $user->password = $input;
            $user->image = $request->image;
            $user->save();

            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $request->name;
            $success['email'] =  $request->email;
            $success['phone'] =  $request->phone;
            $success['password'] =  $request->password;
            $success['rashi'] =  $request->rashi;
    
            return $this->sendResponse($success, 'User register successfully.');
        }
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        $rule = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        if($validate = validateRequest($request, $rule)){
            return returnWithError($validate);
        }else{

            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
                $success['name'] =  $user->name;
                $success['email'] =  $user->email;
                $success['phone'] =  $user->phone;
                $success['password'] = $user->password;
                $success['rashi'] =  $user->rashi;


                return $this->sendResponse($success, 'User login successfully.');
            } 
            else{ 
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            } 
        }
    }
    
    public function forgot_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        if($status == Password::RESET_LINK_SENT){
            return [
                'status' => __($status)
            ];
        }
        throw ValidationException::withMessages([
            'email' =>[trans($status)]
        ]);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $status = Password::reset(
            $request->only('email','password','password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
        
    
        if($status == Password::PASSWORD_RESET){
            return response()->json(['message' => 'Password Reset successfully']);
            // return returnJsonResponse('','Password Reset successfully');
        }
        return returnJsonResponse(500, __($status));
    }

    public function logout(){
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Logout successfully']);
    }

    public function contact(){
        try{
            $rule = [
                'name' => 'required',
                'email' => 'required|email',
                'contact' => 'required',
                'msg' => 'required'
            ];

            if($validate = validateRequest($request, $rule)){
                return $validate;
            }else{
                $contact = new Contact;
                $contact->name = $request->name;
                $contact->email = $request->email;
                $contact->contact = $request->contact;
                $contact->msg = $request->msg;
                $contact->save();
                return returnJsonResponse(200,'Contact Added Successfully');
            }
        }catch(\Exception $e){
            return returnJsonResponse(500,$e) ;
        }
    }
}
