<?php

namespace App\Http\Controllers\Api\V1\Auth\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRegisterConfirmRequest;
use App\Http\Requests\Auth\LoginRegisterRequest;
use App\Http\Resources\OtpResource;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\Sms\SmsService;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config; 
use Illuminate\Support\Str;
use Carbon\Carbon;
 use Illuminate\Support\Facades\Validator;

class LoginRegisterController extends Controller
{
    public function loginRegister(LoginRegisterRequest $request)
    {
        $inputs =  $request->all();
        //check id is email or not
        if (filter_var($inputs['id'], FILTER_VALIDATE_EMAIL)) {
            $type = 1; //is email
            $user =  User::where('email', $inputs['id'])->first();
            if (empty($user)) {
                $newUser['email'] = $inputs['id'];
            }
        }
      

        //check id is mobile or not
        elseif (preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['id'])) {
            $type = 0; //0=>mobile

            //all mobile numbers are on in format 9** *** ***

            $inputs['id'] = ltrim($inputs['id'], '0');
            $inputs['id'] = substr($inputs['id'], 0, 2) === '98' ? substr($inputs['id'], 2) : $inputs['id'];
            $inputs['id'] = str_replace('+98', ' ', $inputs['id']);
            $user = User::where('mobile', $inputs['id'])->first();
            if (empty($user)) {
                $newUser['mobile'] = $inputs['id'];
            }
        } else {
            $errorText = 'شناسه ی  ورودی شما نه شمارهموبایل است نه ایمیل';
            return  response()->json(['id' => $errorText]);

        }
        if (empty($user)) {
            $newUser['password'] = '98355154';
            $newUser['activation'] = 1;
            $user = User::create($newUser);
        }
        //create otp code
        $otpCode = rand('111111', '999999');
        $token =  Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $inputs['id'],
            'type' => $type
        ];
         Otp::create($otpInputs);

        //send email or sms

        if ($type == 0) {
            //send sms

            $smsService = new SmsService();
            $smsService->setFrom(Config::get('sms.otp_from'));
            $smsService->setTo(['0' . $user->mobile]);
            $smsService->setText("مجموعه ی آمازون \n کد تایید شما: $otpCode");
            $smsService->setIsFlash(true);

            $messageService = new MessageService($smsService);
        } elseif ($type == 1) {
            $emailService = new EmailService();
            $details = [
                'title' => 'ایمیل فعال سازی',
                'body' =>  "کد تایید شما : $otpCode"
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com', 'example');
            $emailService->setTo($inputs['id']);
            $emailService->setSubject('کد احراز هویت');
            $messageService = new MessageService($emailService);
        }
        $messageService->send();
        return response()->json(['status'=>200 ,  'token'=> $token]);
    }

    public function loginConfirmForm($token)
    {
        $otp = Otp::where('token', $token)->first();
        if (empty($otp)) {
            return  response()->json(['id' => ' آدرس وارد شده نامعتبر می باشد.']);
        }
         
        return  response()->json(['status'=>200 ,  'token'=>$token , 'otp' =>new OtpResource($otp) ]);
    }
    public function loginConfirm($token ='',  LoginRegisterConfirmRequest $request)
    {
        
        $inputs = $request->all();
        $otp = Otp::where('token' , $token)->where('used' , 0)->where('created_at' ,'>=', Carbon::now()->subMinute(2)->toDateTimeString())->first();  
        if (empty($otp)) {
            return  response()->json(['status'=>404 ,'otp' => ' کد وارد شده نامعتبر می باشد.']);
        }
        //if otp not match
        if ($otp->otp_code !== $inputs['otp'] ) {
           
            return   response()->json(['status'=>404 , 'otp' => ' کد وارد شده اشتیاه می باشد.']);
        }
        //if evrything is ok:
       
            $otp->update(['used' => 1]);
            $user = $otp->user->first();
          if ($otp->type == 0  && empty($user->mobile_verified_at)) {
        
            $user->update(['mobile_verified_at'=>Carbon::now()]);
          }
          elseif ($otp->type == 1 && empty($user->email_verified_at)) {     
            $user->update(['email_verified_at'=>Carbon::now()]);
          }


           $userAuth = Auth::login($user);
           return  response()->json(['status'=>200 , 'token'=>$user->createToken('API TOKEN')->plainTextToken , 'message'=>'login successful' ]);


    }

    public function loginResendOtp($token){
        $otp = Otp::where('token' , $token)->where('created_at' ,'<=', Carbon::now()->subMinute(2)->toDateTimeString())->first();  
        if (empty($otp)) {
            return  response() ->json(['id' => ' آدرس وارد شده نامعتبر می باشد.']);
        }
        $user =  $otp->user->first();
        //create otp code
        $otpCode = rand('111111', '999999');
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $otp->login_id,
            'type' => $otp->type
        ];
        Otp::create($otpInputs);

        //send email or sms

        if ($otp->type == 0) {
            //send sms
           
            $smsService = new  SmsService();
            $smsService->setFrom(Config::get('sms.otp_from'));
            $smsService->setTo(['0' . $user->mobile]);
            $smsService->setText("مجموعه ی آمازون \n کد تایید شما: $otpCode");
            $smsService->setIsFlash(true);

            $messageService = new MessageService($smsService);
        } elseif ($otp->type == 1) {
            $emailService = new  EmailService();
            $details = [
                'title' => 'ایمیل فعال سازی',
                'body' =>  "کد تایید شما : $otpCode"
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com', 'example');
            $emailService->setTo($otp->login_id);
            $emailService->setSubject('کد احراز هویت');
            $messageService = new  MessageService($emailService);
        }
        $messageService->send();
      
           return  response()->json(['status'=>200 ,  'token'=> $token ]);
  
    }
    public function logout(){
        // $user->tokens()->delete();
        Auth::logout();
        return  response()->json(['status'=>200]);

    }
}


