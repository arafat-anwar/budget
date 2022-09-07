<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Sector;
use DB;

class SectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'sectors' => DB::select("select * from `sectors` where `user_id` = ".auth()->user()->id)
        ];
        return view('sectors.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sectors.create');
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
            'type' => 'required',
            'name' => 'required',
        ]);

        $sector = DB::select("insert into `sectors` (`user_id`, `name`, `type`) values ('".auth()->user()->id."', '".$request->name."', '".$request->type."')");
        return is_save($sector, "Sector has been saved successfully.");
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'sector' => DB::select("select * from `sectors` where `id` = ".$id)[0]
        ];
        return view('sectors.edit', $data);
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
        $request->validate([
            'type' => 'required',
            'name' => 'required',
        ]);

        $sector = DB::select("UPDATE `budget`.`sectors` SET `name` = '".$request->name."', `type` = '".$request->type."' WHERE `id` = '".$id."'");
        return is_save($sector, "Sector has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::select("DELETE FROM `sectors` WHERE `id` = '".$id."'");
        return response()->json([
            'success' => true
        ]);
    }
}
