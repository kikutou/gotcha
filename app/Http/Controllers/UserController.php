<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function change_password(Request $request)
    {
    	if ($request->isMethod("post")) {
		    $rules = [
			    'password' => 'required|min:5',
			    'password_confirm' => 'required|min:5|same:password',
		    ];

		    $errors = [
			    'password.required' => 'パスワードを入力してください',
			    "password.min" => ":min桁以上のパスワードを入力してください",
			    'password_confirm.required' => 'パスワードを入力してください',
			    "password_confirm.min" => ":min桁以上のパスワードを入力してください",
			    "password_confirm.same" => "同じパスワードを入力してください",

		    ];

		    $validator = Validator::make($request->all(), $rules, $errors);

		    if($validator->fails()) {
		    	return redirect()->back()->withErrors($validator)->with("error", "パスワードリセットが失敗しました。");
		    } else {
		    	$new_password = $request->get("password");
		    	$user = Auth::user();
		    	$user->password = Hash::make($new_password);
		    	$user->save();

		    	return redirect()->back()->with("message", "パスワードをリセットしました。");
		    }
	    }
    	return view("user.change_password");
    }
}
