<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Globals\Authenticator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Tbl_member;
use App\Tbl_login;

class LoginController extends Controller
{
    public function to_login()
    {
        return redirect("/login");
    }
    public function index()
    {
    	return view("login");
    }
    public function register()
    {
    	return view("register");
    }
    public function login_submit(Request $request)
    {
        $rules["username"]                  = array("required");
        $rules["password"]                  = array("required", "min:6");
        $validator                          = Validator::make($request->all(), $rules);

        /* VALIDATE LOGIN */
        if($validator->fails())
        {
            $errors = $validator->errors()->all();
            return redirect('/login')->with("errors", $errors)->withInput();
        }
        else
        {
            /* AUTHENTICATE LOGIN */
            $username_email                 = $request->username;
            $check_member                   = Tbl_member::where("username", $username_email)->first();

            if(!$check_member)
            {
                $check_member               = Tbl_member::where("email", $username_email)->first();
            }

            if($check_member)
            {
                if (Hash::check($request->password, $check_member->password))
                {
                    /* CHECK EMAIL VERIFICATION */
                    if($check_member->verified_mail==0)
                    {
                        $errors[0] = "Verify your email address first.";
                        return redirect('/login')->with("errors", $errors)->withInput();
                    }
                    else
                    {
                        Authenticator::login($check_member->member_id, $check_member->password);
                        return redirect('/app');
                    }
                    
                }
                else
                {
                    $errors[0] = "You entered an invalid account.";
                    return redirect('/login')->with("errors", $errors)->withInput();
                }
            }
            else
            {
                $errors[0] = "You entered an invalid account.";
                return redirect('/login')->with("errors", $errors)->withInput();
            }
        }
    }
    public function register_submit(Request $request)
    {
        /* INITIALIZE RULES */
		$rules["first_name"]              = array("required", "string");
		$rules["last_name"]               = array("required", "string");
		$rules["email_address"]           = array("required", "email", "unique:tbl_member,email");
		$rules["username"] 		          = array("required", "alpha_dash", "unique:tbl_member");
		$rules["password"]                = array("required", "confirmed", "min:6");

        $validator = Validator::make($request->all(), $rules);

        /* VALIDATE REGISTRATION */
        if($validator->fails())
        {
        	$errors = $validator->errors()->all();
            return redirect('/register')->with("errors", $errors)->withInput();
        }

        else
        {
            /* INSERT ACCOUNT TO DATABASE */
        	$insert["first_name"]			= $request->first_name;
        	$insert["last_name"] 			= $request->last_name;
        	$insert["email"] 				= $request->email_address;
        	$insert["username"] 			= $request->username;	
        	$insert["password"] 			= Hash::make($request->password);
        	$insert["create_date_time"] 	= Carbon::now();
            $insert["last_work_time"]       = Carbon::now();
            $insert["member_task"]          = 0;
        	$insert["sponsor"] 				= 0;
        	$insert["create_ip_address"] 	= $_SERVER['REMOTE_ADDR'];
            $insert["verified_mail"]        = 1;
        	$member_id                      = Tbl_member::insertGetId($insert);

        	return redirect("/login")->with("success", "Registration successful! You can now login using your account.");
        }
    }
}
