<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleBack(Request $request)
    {
        try {
            $user_google = Socialite::driver('google')->user();
            $user = DB::table('users')->where('google_id','=',$user_google->id )->first();

            if($user){
                $request->session()->put('LoggedUser',$user->UserId);
                return redirect('/profile');
            }

            $newUser = DB::table('users')->insert([
                'fullname' => $user_google->name,
                'email' => $user_google->email,
                'google_id'=> $user_google->id,
                'password' => Hash::make('123456')
            ]);
            $userNew = DB::table('users')->select('UserId')->where('email','=',$user_google->email )->first();
            $request->session()->put('LoggedUser',$userNew->UserId);
            return redirect('/profile');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    // login facebook
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function facebookBack(Request $request)
    {
        try{
            //if Authentication is successfully.
            $user_facebook = Socialite::driver('facebook')->user();
            $user = DB::table('users')->where('facebook_id','=',$user_facebook->getId() )->first();

            if($user){
                $request->session()->put('LoggedUser',$user->UserId);
                return redirect('/profile');
            }

            $newUser = DB::table('users')->insert([
                'fullname' => $user_facebook->getName(),
                'email' => $user_facebook->getEmail(),
                'facebook_id'=> $user_facebook->getId(),
                'password' => Hash::make('123456')
            ]);
            $request->session()->put('LoggedUser',$newUser->UserId);
            return redirect('/profile');
        }catch(\Exception $e){
            //Authentication failed
            return redirect()->back()->with('status','đăng nhập goodle đang bị lỗi, làm ở thử lại sau!');
        }
    }
}
