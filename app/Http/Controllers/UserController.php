<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Generate user token if successfully logged in.
     */
    public function authenticate(Request $request)
    {
        // try {

            // Validate request data
            $request->validate([
                'email' => ['required','email','regex:/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'],
                'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).*$/',
            ]);

            // Check if the user is not registered
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return back()->with('message', 'Incorrect email. Please try again.')->with('status', 'danger');
            }
            
            // Check if the password matched
            if (!Hash::check($request->password, $user->password)) {
                return back()->with('message', 'Incorrect password. Please try again.')->with('status', 'danger');
            }

            // Generate a token
            $token = $user->createToken($user->email)->plainTextToken;
            session(['token' => $token]);

            // Return data and message
            return response()->json([
                'data' => [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'token' => $token,
                    'session:token' => session('token'),
                ],
                'message' => "Login successfully."
            ], 200);
        // ], 200)->header('Authorization', 'Bearer '.session('token').'');
            // return view('jobpost', ['data' => [
            //             'first_name' => $user->first_name,
            //             'last_name' => $user->last_name,
            //             'email' => $user->email,
            //             'token' => $token,
            //             'session:token' => session('token'),
            //         ]]);

        // } catch (\Exception $e) {

        //     // return back()->with('message', $e->getMessage())->with('status', 'danger');
        //     return response()->json([
        //         'message' => $e->getMessage(),
        //         'status-alert' => 'danger'
        //     ], 200);
        // }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function create_account(Request $request)
    {
        
        try {

            // Validate request data
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => ['required','email','unique:users','regex:/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'],
                'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).*$/',
            ]);
            /**
             *  Password rule:
             *      -minimum eight characters,
             *      -at least one upper case English letter, 
             *      -one lower case English letter, 
             *      -one number and 
             *      -one special character:  #?!@$ %^&*-
            */

            // Create user account
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            return back()->with('message', 'Account created successfully.')->with('status', 'success');

        } catch(\Exception $e) {
            return back()->with('message', $e->getMessage())->with('status', 'danger');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            
            // Retrieve user details
            $user=User::find(auth('sanctum')->user()->id);

            if(!$user)
            {
                return response()->json([
                    'message' => 'User not found.'
                ], 400);
            }

            return response()->json([
                'data' => $user
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            
            // Validate request data
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
            ]);
    
            // Update user details
            DB::beginTransaction();

            $user=User::find(auth('sanctum')->user()->id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->save();

            DB::commit();

            return response()->json([
                'data' => $user,
                'message' => 'Your name has successfully changed.'
            ], 200);

        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 400);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function change_password(Request $request)
    {
        try {
            
            // Validate request data
            $request->validate([
                'old_password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).*$/',
                'new_password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).*$/',
            ]);
    
            // Check if the password don't matched
            $user=User::find(auth('sanctum')->user()->id);

            if (!Hash::check($request->old_password, $user->password)) {
                return response([
                    'message' => "Old password doesn't match. Please try again."
                ], 401); 
            }

            // Update user's password
            DB::beginTransaction();
            $user->password = bcrypt($request->new_password);
            $user->save();
            DB::commit();

            return response()->json([
                'data' => $user,
                'message' => 'Password has successfully changed.'
            ], 200);

        } catch (\Exception $e) {
            
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 400);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    /**
     * Remove token assigned to a user.
     */
    public function logout(Request $request)
    {
        try {
            // Delete the user's valid token
            auth()->user()->tokens()->delete();

            return response()->json([
                'message' => 'User logged out.'
            ], 200);

        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);

        }
        
    }


    public function getDetails(Request $request)
    {
        $userId = Auth::id();
        $user = User::find($userId);

        // return view('dashboard', [
        //     'user' => $user,
        // ]);

        return redirect()->route('profile.edit', [
                'user' => $user,
            ]);
    }
}
