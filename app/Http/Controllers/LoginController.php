<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request) {
        $finUsername = $request->input('username');
        $finPassword = $request->input('password');
        $ldap = ldap_connect("ldap://misys.global.ad:389");
        $ldaprdn = 'MISYSROOT' . "\\" . $finUsername;

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);


        if (@ldap_bind($ldap, $ldaprdn, $finPassword)) {
            if (Auth::attempt($request->only('username','password'))) {
                return response()->json(Auth::user(), 200);
            } else {

                $user = User::where('username', $request->username)->first();

                if ($user === null) {
                    User::create([
                        'name' => $request->username,
                        'username' => $request->username,
                        'password' => Hash::make($request->password)
                    ]);
                 }

                if (Auth::attempt($request->only('username','password'))) {
                    return response()->json(Auth::user(), 200);
                }
            }
        } else {
            return 'rektboi';
            throw ValidationException::withMessages([
                'username' => ['Do you really work for Finastra?']
            ]);
        }



    }

    public function logout() {
        Auth::logout();
    }
}
