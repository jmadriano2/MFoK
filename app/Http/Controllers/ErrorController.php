<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $error = $request->isMethod('put') ? Error::findorFail
        ($request->error_id) : new Error;

        $error->id = $request->input('error_id');
        $error->component = $request->input('component');
        $error->resolution = $request->input('resolution');
        $error->og_resolver = $request->input('og_resolver');

        if($error->save()) {
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

        if($error->delete()) {
            return new ErrorResource($error);
        }
    }
}
