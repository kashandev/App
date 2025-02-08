<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RestaurantUser;
use App\Models\RestaurantActivityLogs;
use App\Models\RestaurantMessage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RestaurantUserController extends Controller
{
    // Add User Function
public function adduser(Request $request)
{
    try {
        // Get the user by login name
        $check_user = RestaurantUser::where('login_name', $request->login_name)
         ->where('status', 'Active')
        ->get();
        $check_email = RestaurantUser::where('email', $request->email)
        ->where('status', 'Active')
       ->get();
        if ($check_user->isNotEmpty()) {
            // Access the first user in the collection
            $login_name_row = $check_user->first();
        } 
        else {
            $login_name_row = '';
        } 
        if ($check_email->isNotEmpty()) {
            // Access the first user in the collection
            $email_row = $check_email->first();
        }  
        else {
            $email_row = '';
        }
        // Check if the user exist
        if ($login_name_row != '' ) {
            return response()->json(['success' => false,'title' => 'Exist!','message' => 'Login Name' .' '. $request->login_name . ' Already Taken Try Different. '], 401);
        }
        // Check if the email exist
        if ($email_row != '') {
           return response()->json(['success' => false,'title' => 'Exist!','message' => 'Email' .' '. $request->email . ' Already Exist. '], 401);
        }
        else {
    
          $password = Hash::make($request->password_hash);
          $created_by = preg_replace('/^"(.*)"$/', '$1',  $request->created_by);
        // Create user query
        RestaurantUser::create([
            'user_type' => $request->user_type,
            'user_name' => $request->user_name,
            'login_name' => $request->login_name,
            'email' => $request->email,
            'password_hash' => $password
        ]);

        // Create activity logs query
        RestaurantActivityLogs::create([
            'activity' => 'Add User',
            'ip' => $request->ip(),
            'device_name' => $request->header('User-Agent'),
            'created_by' =>  $created_by,
        ]);

        // Create message query
        RestaurantMessage::create([
            'message_type' => 'Create User'
        ]);

        // Customize the response
        $response = [
            'success' => true,
            'title' => 'Created!',
            'message' => 'User Successfully Created',
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
    // Add User Function
    public function getusers()
    {
        try {

            $user_type = ['User','Staff'];
            // Get the users
            $get_user = RestaurantUser::whereIn('user_type', $user_type)
             ->where('status', 'Active')
             ->get();
            if ($get_user->isNotEmpty()) {
                // Access the first user in the collection
                $users_row = $get_user->all();
            }  
            else {
                $users_row = '';
            }
    
            // Check if the user does not exist
            if ($get_user == '') {
                return response()->json(['message' => 'No User Found'], 404);
            }
            else {

                
            // Customize the response
            $response = [
                'user' => $users_row,
                'success' => true
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


}


