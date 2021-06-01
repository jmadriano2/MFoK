<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Models\Error;
use App\Http\Resources\Error as ErrorResource;

class ErrorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Error::with(['resolver'])->get();
    }
    /**
     * Display a list of errors that does not exist in current CoB Log.
     *
     * @return \Illuminate\Http\Response
     */
    public function unselectedErrors($log_id)
    {
        //Get Errors
        return Error::whereNotIn('id', function($query) use($log_id) {
            $query->select('error_id')
            ->from('logs_contains_errors')
            ->where('log_id', $log_id);
        })->with(['resolver'])->get();
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
            'component' => 'required',
            'sequence' => 'required',
            'problem' => 'required',
            'resolution' => 'required',
        ]);

        return Error::create(array_merge($request->all(),
            [
                'resolver_id' => auth()->user()->id,
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
        return Error::find($id);
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
        $error = Error::find($id);
        $error->update($request->all());
        return $error;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Error::destroy($id);
    }
}
