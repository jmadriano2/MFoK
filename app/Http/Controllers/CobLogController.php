<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\CobLog;
use App\Models\CoblogError;
use App\Http\Resources\CobLog as CobLogResource;
use App\Http\Resources\CoblogError as CoblogErrorResource;
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
        ->select(
            'cob_logs.id',
            'cob_logs.system_id',
            'cob_logs.runday',
            'cob_logs.next_working_day',
            'cob_logs.start',
            'cob_logs.end',
            'cob_logs.status',
            'cob_logs.runtime',
            'cob_logs.conclusion',
            'cob_logs.creator',
            'cob_logs.created_at',
            'cob_logs.updated_at',
            'systems.id as s_id',
            'systems.machine',
            'systems.system',
            'systems.zone',
            'systems.release',
            'systems.created_at as s_cat',
            'systems.updated_at as s_uat',
            )
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
    public function storeCoblogError(Request $request)
    {
        $coblogError = new CoblogError;

        $coblogError->log_id = $request->input('log_id');
        $coblogError->error_id = $request->input('error_id');

        if($coblogError->save()) {
            return new CoblogErrorResource($coblogError);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coblog = $request->isMethod('put') ? CobLog::findorFail
        ($request->system_id) : new CobLog;

        $coblog->id = $request->input('id');
        $coblog->system_id = $request->input('system_id');
        $coblog->runday = $request->input('runday');
        $coblog->next_working_day = $request->input('next_working_day');
        $coblog->start = Carbon::now();
        $coblog->status = $request->input('status');
        $coblog->runtime = $request->input('runtime');
        $coblog->conclusion = $request->input('conclusion');
        $coblog->creator = $request->input('creator');

        if($coblog->save()) {
            return new CobLogResource($coblog);
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
        ->select(
            'log_id',
            'error_id',
            'logs_contains_errors.created_at',
            'logs_contains_errors.updated_at',
            'errors.component',
            'errors.sequence',
            'errors.problem',
            'errors.resolution',
            'errors.og_resolver',
            'errors.created_at as err_cr_at',
            'errors.updated_at as err_up_at',
            )
        ->join('errors','logs_contains_errors.error_id','=','errors.id')
        ->where(['logs_contains_errors.log_id' => $id])
        ->orderBy('created_at', 'DESC')
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
