<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Sector;
use \App\Models\Entry;
use DB;

class EntryController extends Controller
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
        $sector_id = request()->has('sector_id') ? request()->get('sector_id') : 1;
        $from = request()->has('from') ? request()->get('from') : date('Y-m-01');
        $to = request()->has('to') ? request()->get('to') : date('Y-m-t');

        $data = [
            'sector_id' => $sector_id,
            'from' => $from,
            'to' => $to,
            'sectors' => [
                'incomes' => DB::select("select * from `sectors` where `user_id` = ".auth()->user()->id." and type = 'income' order by name asc"),
                'expenses' => DB::select("select * from `sectors` where `user_id` = ".auth()->user()->id." and type = 'expense' order by name asc"),
            ],
            'entries' => DB::select("select `entries`.*, `sectors`.name as sector_name, `sectors`.type as sector_type from `entries` inner join sectors on `entries`.sector_id = `sectors`.id where exists (select * from `sectors` where `entries`.`sector_id` = `sectors`.`id` and `sectors`.`user_id` = ".auth()->user()->id.") ".($sector_id > 0 ? 'and `entries`.`sector_id` = 1' : '')." and `entries`.`date` >= '".$from."' and `entries`.`date` <= '".$to."'"),
        ];
        return view('entries.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'sectors' => [
                'incomes' => DB::select("select * from `sectors` where `user_id` = ".auth()->user()->id." and type = 'income' order by name asc"),
                'expenses' => DB::select("select * from `sectors` where `user_id` = ".auth()->user()->id." and type = 'expense' order by name asc"),
            ]
        ];
        return view('entries.create', $data);
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
            'sector_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'title' => 'required',
            'amount' => 'required',
        ]);

        $entry = DB::select("INSERT INTO `entries`(`sector_id`, `date`, `time`, `title`, `amount`) VALUES ('".$request->sector_id."', '".$request->date."', '".$request->time."', '".$request->title."', '".$request->amount."')");

        return is_save(true, "Entry has been saved successfully.");
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
            'sectors' => [
                'incomes' => DB::select("select * from `sectors` where `user_id` = ".auth()->user()->id." and type = 'income' order by name asc"),
                'expenses' => DB::select("select * from `sectors` where `user_id` = ".auth()->user()->id." and type = 'expense' order by name asc"),
            ],
            'entry' => Entry::find($id)
        ];

        return view('entries.edit', $data);
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
            'sector_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'title' => 'required',
            'amount' => 'required',
        ]);

        DB::select("UPDATE `budget`.`entries` SET `sector_id` = '".$request->sector_id."', `date` = '".$request->date."', `time` = '".$request->time."', `title` = '".$request->title."', `amount` = '".$request->amount."' WHERE `id` = '".$id."'");
        return is_save(true, "Entry has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::select("DELETE FROM `entries` WHERE `id` = '".$id."'");
        return response()->json([
            'success' => true
        ]);
    }
}
