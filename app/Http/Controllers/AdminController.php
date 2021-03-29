<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Resources\Admin as AdminResource;
use App\Http\Requests;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::paginate(5);
        return AdminResource::collection($admins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = $request->isMethod('put') ? Admin::findOrFail($request->username) : new Admin();
        $admin->username = $request->input('username');
        $admin->password = $request->input('password');
        if($admin->save()) {
            return new AdminResource($admin);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $admin = Admin::findOrFail($username);
        return new AdminResource($admin);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($username)
    {
        $admin = Admin::findOrFail($username);
        if($admin->delete()) {
            return new AdminResource($admin);
        }
    }

    /**
     * Checks for the validity of username and password combination.
     *
     * @param string $finUsername The user's corporate log in name.
     * @param string $finPassword The user's corporate log in password.
     * @return boolean True if the username and password combination is correct, false if otherwise.
     */
    public function corporateLogin(Request $request)
    {
        $finUsername = $request->input('username');
        $finPassword = $request->input('password');
        $ldap = ldap_connect("ldap://misys.global.ad:389");
	    $ldaprdn = 'MISYSROOT' . "\\" . $finUsername;

	    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
	    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        //@ldap_bind is true if the credentials are correct
	    if (@ldap_bind($ldap, $ldaprdn, $finPassword)) {
		    return true;
	    } else {
		    return false;
	    }
    }
}
