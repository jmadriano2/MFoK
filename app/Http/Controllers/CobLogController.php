<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Error;
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
        return CobLog::with(['system','logger'])->get();
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
        $request->validate([
            'system_id' => 'required',
            'runday' => 'required',
            'next_working_day' => 'required',
            'status' => 'required',
            'runtime' => 'required',
        ]);

        return CobLog::create(array_merge($request->all(),
            [
                'logger_id' => auth()->user()->id,
                'start' => Carbon::now(),
            ])
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return CobLog::with(['system','logger'])->where('id', $id)->get();
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
        $coblog = CobLog::find($id);
        $coblog->update($request->all());
        return $coblog;
    }

    /**
     * Display the existing errors assigned to a CoB Log.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showErrors($id)
    {
        $coblogErrors = CobLog::find($id)->errors()->with('resolver')->orderBy('created_at', 'DESC')->get();
        return $coblogErrors;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($log_id, $error_id)
    {
        // Get Error
        $error = Error::findOrFail($error_id);


        if($error->logs()->detach($log_id)) {
            return new CobLogErrorResource($error);
        }
    }
}
