<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function display_sample_login()
    {
        // $data = Job::where("status","open")->get();
        return view('samplelogin');
    }

    public function login_post(Request $request)
    {
        // RateLimiter::clear('login:'.$request->email);
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $user = User::where("email",$request->email)->get();
        $isLoginSuccessful = false;

        if($user!=null)
        {
            if(Hash::check($request->password, $user[0]->password))
            {
                $isLoginSuccessful = true;
                // return redirect()->route('page');
            }
            else
            {
                RateLimiter::hit('login:'.$request->email,$decaySeconds = 1800);
            }
        }
        else
        {
            RateLimiter::hit('login:'.$request->email,$decaySeconds = 1800);
        }

        if (RateLimiter::tooManyAttempts('login:'.$request->email, $perMinute = 3)) 
        {
            $seconds = RateLimiter::availableIn('login:'.$request->email);
            $minutes = floor($seconds/60);

            if($minutes!=0)
            {
                return back()->with('message', 'You may try again in '.$minutes.' minutes.');
            }
        
            return back()->with('message', 'You may try again in '.$seconds.' seconds.');
        }
        else
        {
            if($isLoginSuccessful)
            {
                return redirect()->route('page');
            }
            else
            {
                return back()->with('message', 'Incorrect email or password!.');
            }
        }

        
        // if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        // {
        //     // if (auth()->user()->role == 'admin')
        //     // {
        //         return redirect()->route('table');
        //     // }
        //     // else
        //     // {
        //     //   return redirect()->route('home');
        //     // }
        // }
        // else
        // {
        //     return redirect()
        //     ->route('login')
        //     ->with('error','Incorrect email or password!.');
        // }
        // return redirect()->route('table');
    }
}
