<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Carbon\Carbon;
use App\User;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('username', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
		}
		
		$user = auth()->user();

		// save ip address and last login date of user to db
		
		//get last login date - from server time
 		$timestamp = time();
		$last_login_date = date("Y-m-d", $timestamp);
		
		//get last login ip
		$ip_address = file_get_contents('https://api.ipify.org');
		
		//update user on db
		User::where('id', $user->id)->update(array('last_ip_address' => $ip_address, 'last_login_date' => $last_login_date));

        // all good so return the token
        return response()->json(compact('token','user'));
    }

    public function check()
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response(['authenticated' => false]);
        }
        return response(['authenticated' => true]);
    }

    public function logout()
    {
        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }

        } catch (JWTException $e) {
            return response()->json($e->getMessage(), 401);
        }
        return response()->json(['message' => 'Log out success'], 200);
    }
}
