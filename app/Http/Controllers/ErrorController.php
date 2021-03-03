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
        //Get Errors
        $errors = Error::all();

        return ErrorResource::collection($errors);
    }
    /**
     * Display a list of errors that does not exist in current CoB Log.
     *
     * @return \Illuminate\Http\Response
     */
    public function unselectedErrors($log_id)
    {
        //Get Errors
        $errors = Error::whereNotIn('id', function($query) use($log_id) {
            $query->select('error_id')
            ->from('logs_contains_errors')
            ->where('log_id', $log_id);
        })->get();

        return ErrorResource::collection($errors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $error = $request->isMethod('put') ? Error::findorFail($request->error_id) : new Error;

        $error->id = $request->input('error_id');
        $error->component = $request->input('component');
        $sequence = $request->input('sequence');
        if ((int) $sequence < 10000) {
            $sequence = str_pad($sequence, 5, '0', STR_PAD_LEFT);
        }
        $error->sequence = $sequence;
        $error->problem = $request->input('problem');
        $error->resolution = $request->input('resolution');
        $error->og_resolver = $request->input('og_resolver');

        if ($error->save()) {
            return new ErrorResource($error);
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
        $error = Error::findOrFail($id);

        return new ErrorResource($error);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $error = Error::findOrFail($id);

        if ($error->delete()) {
            return new ErrorResource($error);
        }
    }
}
