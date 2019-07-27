<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Validator;

use App\Model\user_detail;
use App\Model\user_auth;
use JWTAuth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class ApiController extends Controller
{
    public function register(Request $request)
    {
        $userdetails = new user_detail();
        $userauth = new user_auth();
        $payload = request(['name', 'user_name', 'dob', 'gender', 'slack_id', 'gmail_id', 'contact', 'password']);
        $rules = [
            "name" => "required",
            "user_name" => "required|unique:users",
            "dob" => "required|date",
            "gender" => "required",
            "slack_id" => "required|unique:users",
            "gmail_id" => "required|email|unique:users",
            "contact" => 'required',
            "password" => "required|min:8"
        ];

        $validator = Validator::make($payload, $rules);

        if ($validator->fails()) return response()->json($validator->errors());
        else {
            $userdetails->fill([
                'name' => $request->input('name'),
                'user_name' => $request->input('user_name'),
                'dob' => $request->input('dob'),
                'gender' => $request->input('gender'),
                'slack_id' => $request->input('slack_id'),
                'gmail_id' => $request->input('gmail_id'),
                'contact' => $request->input('contact')
            ])->save();
            $userauth->fill([
                'user_name' => $request->input('user_name'),
                'password' => Hash::make($request->input('password'))
            ])->save();
            return response()->json('Register Success');
        }
        //return response()->json($userdetails + $userauth);
    }

    public function login(Request $request)
    {

        $userrequest = $request->only('user_name');
        try {
            if (!$token = auth()->attempt($userrequest)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
        echo response()->json($userrequest);
        echo response()->json($token);


        // $payload = request(['user_name', 'password']);

        // $rules = [
        //     "user_name" => "required",
        //     "password" => "required|min:8"
        // ];

        // $validator = Validator::make($payload, $rules);

        // if ($validator->fails()) return response()->json($validator->errors());
        // else {
        //     $user = user_auth::where('user_name', $user_auth['user_name'])->first();
        //     echo $user;
        //     // $token = auth()->attempt($user);
        //     // if (Hash::check($pwd, $user->password))
        //     // return response()->json(['token' => $token]);
        // }
    }

    public function alluser()
    {
        $user = user_detail::all();
        return response()->json($user);
    }

    public function deleteuser(Request $request)
    {
        $user_name = $request->input('user_name');
        userdetail::where('user_name', $user_name)->delete();
        $user = userdetail::all();
        return response()->json($user);
    }
}
