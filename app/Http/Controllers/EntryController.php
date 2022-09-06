<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Sector;
use \App\Models\Entry;

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
        $sector_id = request()->has('sector_id') ? request()->get('sector_id') : 0;
        $from = request()->has('from') ? request()->get('from') : date('Y-m-01');
        $to = request()->has('to') ? request()->get('to') : date('Y-m-t');
        $data = [
            'sector_id' => $sector_id,
            'from' => $from,
            'to' => $to,
            'sectors' => [
                'incomes' => Sector::where('user_id', auth()->user()->id)->where('type', 'income')->orderBy('name', 'asc')->get(),
                'expenses' => Sector::where('user_id', auth()->user()->id)->where('type', 'expense')->orderBy('name', 'asc')->get(),
            ],
            'entries' => Entry::whereHas('sector', function($query){
                return $query->where('user_id', auth()->user()->id);
            })
            ->when($sector_id > 0, function($query) use($sector_id){
                return $query->where('sector_id', $sector_id);
            })
            ->where('date', '>=', $from)
            ->where('date', '<=', $to)
            ->get(),
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
                'incomes' => Sector::where('user_id', auth()->user()->id)->where('type', 'income')->orderBy('name', 'asc')->get(),
                'expenses' => Sector::where('user_id', auth()->user()->id)->where('type', 'expense')->orderBy('name', 'asc')->get(),
            ],
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

        $entry = Entry::create($request->all());
        return is_save($entry, "Entry has been saved successfully.");
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
                'incomes' => Sector::where('user_id', auth()->user()->id)->where('type', 'income')->orderBy('name', 'asc')->get(),
                'expenses' => Sector::where('user_id', auth()->user()->id)->where('type', 'expense')->orderBy('name', 'asc')->get(),
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

        $entry = Entry::find($id);
        $entry->fill($request->all())->save();
        return is_save($entry, "Entry has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Entry::find($id)->delete()){
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong!'
        ]);
    }
}
