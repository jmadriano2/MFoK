<?php

namespace App\Http\Controllers;

use App\Imports\CoblogImport;
use Illuminate\Http\Request;
use App\Models\CobLog;
use App\Models\System;
use Illuminate\Support\Carbon;
use Excel;
use \PhpOffice\PhpSpreadsheet\IOFactory;

class CobLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CobLog::with(['system', 'logger'])->orderBy('updated_at', 'DESC')->get();
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
            'description' => 'required',
            'runday' => 'required',
            'next_working_day' => 'required',
            'status' => 'required',
            'runtime' => 'required',
        ]);

        return CobLog::create(
            array_merge(
                $request->all(),
                [
                    'logger_id' => auth()->user()->id,
                    'start' => Carbon::now(),
                ]
            )
        );
    }

    /**
     * Import Excel file contoining Cob Log Details and Errors.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        // $spreadsheet = IOFactory::load("05featuredemo.xlsx");
        $sheets = Excel::toArray(new CoblogImport, $request->file('select_file'));
        $table = 0;
        $logDetails = [];
        $errors = [];
        $log = [];
        $data = [];

        foreach ($sheets as $sheet) {
            foreach ($sheet as $row) {
                switch ($table) {
                    case 0:
                        if ($row[0] == "D") {
                            $system = System::where('machine', $row[1])
                                ->where('system', $row[2])
                                ->where('zone', $row[3])
                                ->first();
                            if ($system == "") {
                                $system = [
                                    "id" => -1,
                                    "machine" => $row[1],
                                    "system" => $row[2],
                                    "zone" => $row[3],
                                    "release" => $row[4],
                                ];
                            }
                        }
                        break;
                    case 1:
                        if ($row[0] == "D" && $system !== "") {
                            $logDetails = [
                                "system" => $system,
                                "runday" => $row[1],
                                "next_working_day" => $row[2],
                                "description" => $row[3],
                                "status" => $row[4],
                                "start" => $row[5],
                                "end" => $row[6],
                                "runtime" => $row[7],
                                "conclusion" => $row[8],
                            ];
                        }
                        break;
                    case 2:
                        if ($row[0] == "D") {
                            $error = [
                                "component" => $row[1],
                                "sequence" => "".$row[2],
                                "problem" => $row[3],
                                "resolution" => $row[4],
                            ];
                            array_push($errors, $error);
                        }
                        break;
                }
                if ($row[0] == "F") {
                    $table++;
                }
            }
            $log = [
                "logDetails" => $logDetails,
                "errors" => $errors,
            ];
            array_push($data, $log);
            $table = 0;
        }


        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return CobLog::with(['system', 'logger'])->where('id', $id)->get();
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
