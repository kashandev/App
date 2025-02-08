<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RestaurantUser;
use App\Models\LoginSession;
use App\Models\RestaurantLoginActivity;
use App\Models\RestaurantLogoutActivity;
use App\Models\RestaurantMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class RestaurantUserLoginController extends Controller
{
    // Login Function
public function login(Request $request)
{
    try {
        // Get the user by login name
        $user = RestaurantUser::where('login_name', $request->login_name)->get();
        

        if ($user->isNotEmpty()) {
            // Access the first user in the collection
            $user_row = $user->first();
        }  
        else {
            $user_row = '';
        }

        // Check if the user does not exist
        if ($user_row == '') {
           return response()->json(['title' => 'Unauthorized!','error' => 'Unauthorized User.'], 401);
        }
        if (!Hash::check($request->password_hash, $user_row->password_hash)) {
            return response()->json(['title' => 'Unauthorized!', 'error' => 'Unauthorized User.'], 401);
        }
            
     else {

        // Get the current server time
        $serverTime = Carbon::now();

        // Set the desired time zone
        $time_zone = 'Asia/Karachi';
        $session_start = $serverTime->setTimezone($time_zone)->format('H:i:s');

        // Calculate the session end time by adding 21 hours (12 hours + 9 hours)
        $session_end = Carbon::parse($session_start)->addHours(21)->format('H:i:s');

        // Authentication successful, generate and set JWT token
        $token = JWTAuth::fromUser($user_row);
        
        $login_session = LoginSession::where('user_name', $user_row->user_name)
                                      ->where('user_type', $user_row->user_type)         
                                      ->first();
        if ($login_session) {
            $login_session->delete();
        }
        // Create login session query
        LoginSession::create([
            'user_id' => $user_row->user_id,
            'user_type' => $user_row->user_type,
            'user_name' => $user_row->user_name,
            'session_start' => $session_start,
            'session_end' => $session_end,
            'status' => 'Start',
        ]);
    

        // Create login activity query
         RestaurantLoginActivity::create([
            'login_by' => $user_row->user_name,
            'ip' => $request->ip(),
            'device_name' => $request->header('User-Agent'),
            'status' => 'Login',
        ]);

        // Create message query
        RestaurantMessage::create([
            'message_type' => 'Logout'
        ]);

        // Create message query
        RestaurantMessage::create([
            'message_type' => 'Welcome'
        ]);

        // Customize the response
        $response = [
            'title' => 'Login!',
            'success' => 'Successfully Logged in Redirecting...',
            'api_token' => $token,
            'user' => $user_row,
            'session_start' => $session_start,
            'session_end' => $session_end,
            'ip' => $request->ip(),
            'device_name' => $request->header('User-Agent'),
        ];
        
        return response()->json($response);
        
    }
    } catch (\Exception $e) {
        // Log the exception for further analysis
        \Log::error($e);

        // Return a 500 Internal Server Error response
       return response()->json(['title' => 'Invalid Response!','error' => 'Internal Server Error'], 500);
    }
}

    // Logout function
    public function logout(Request $request)
    {
        $user_name = preg_replace('/^"(.*)"$/', '$1',  $request->user_name);
        $user_type = preg_replace('/^"(.*)"$/', '$1',  $request->user_type);
    
        // Create logout activity log
        RestaurantLogoutActivity::create([
            'logout_by' => $user_name,
            'ip' => $request->ip(),
            'device_name' => $request->header('User-Agent'),
            'status' => 'Logout'
        ]);

        $login_session = LoginSession::where('user_name', $user_name)
              ->where('user_type', $user_type)  
              ->where('status', 'Start')   
              ->first();
              
   
        if ($login_session) {
            $status = ['status' => 'End'];
            $login_session->update($status);
        }
    
            return response()->json([
                'success' => true
            ]);
    }
    
    // Show Message Function
    public function showmessage(Request $request)
    {
      $message = RestaurantMessage::where('message_type', $request->message_type)->first();
        if ($message) {
            return response()->json([
                'success' => true
            ]);
        }
    }
    // Hide Message Function
   public function hidemessage(Request $request)
   {
    $message = RestaurantMessage::where('message_type', $request->message_type)->first();
    
        if ($message) {
            $message->delete();
            return response()->json([
                'success' => true
            ]);
        }
    }


}
