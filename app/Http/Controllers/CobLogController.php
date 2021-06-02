<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CobLog;
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
        return CobLog::with(['system','logger'])->orderBy('updated_at', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCoblogError(Request $request)
    {
        $coblog = CobLog::find($request->input('log_id'));
        $coblog->errors()->attach($request->input('error_id'));

        return $coblog->errors->find($request->input('error_id'));
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
        $coblogErrors = CobLog::find($id)->errors()->with('resolver')->orderByPivot('created_at', 'DESC')->get();
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
        $coblog = CobLog::find($log_id);
        $coblog->errors()->detach($error_id);

        return $coblog->errors;
    }
}
