<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\System;
use App\Http\Resources\System as SystemResource;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get All Systems
        $systems = System::all();

        return SystemResource::collection($systems);
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

        $system->id = $request->input('system_id');
        $system->machine = $request->input('machine');
        $system->system = $request->input('system');
        $system->zone = $request->input('zone');
        $system->release = $request->input('release');
        $system->rundate = $request->input('rundate');

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
        $system = System::findOrFail($id);

        return new SystemResource($system);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $system = System::findOrFail($id);

        if($system->delete()) {
            return new SystemResource($system);
        }
    }
}
