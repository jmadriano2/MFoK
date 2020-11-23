<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\CobLog;
use App\Http\Resources\CobLog as CobLogResource;
use Illuminate\Support\Carbon;

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
        $coblogs = CobLog::all();

        return CobLogResource::collection($coblogs);
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
        //
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
