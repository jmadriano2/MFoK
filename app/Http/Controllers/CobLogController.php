<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\CobLog;
use App\Http\Resources\CobLog as CobLogResource;
use Illuminate\Support\Carbon;
use DB;

class CobLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get CobLogs
        $coblogs = DB::table('cob_logs')
        ->select('*')
        ->join('systems','systems.id','=','cob_logs.system_id')
        ->get();

        return new CobLogResource($coblogs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $system = $request->isMethod('put') ? System::findorFail
        ($request->system_id) : new System;

        $system->id = $request->input('coblog_id');
        $system->system_id = $request->input('system_id');
        $system->runday = $request->input('runday');
        $system->next_working_day = $request->input('zone');
        $system->next_working_day = $request->input('next_working_day');
        $system->status = $request->input('status');
        $system->runtime = $request->input('runtime');
        $system->conclusion = $request->input('conclusion');
        $system->creator = $request->input('creator');

        if($system->save()) {
            return new SystemResource($system);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coblog = DB::table('cob_logs')
        ->select('*')
        ->join('systems','systems.id','=','cob_logs.system_id')
        ->where(['cob_logs.id' => $id])
        ->get();
        return new CobLogResource($coblog);
    }

    /**
     * Display the existing errors assigned to a CoB Log.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showErrors($id)
    {
        $coblog = DB::table('logs_contains_errors')
        ->select('*')
        ->join('errors','logs_contains_errors.error_id','=','errors.id')
        ->where(['logs_contains_errors.log_id' => $id])
        ->get();
        return new CobLogResource($coblog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
