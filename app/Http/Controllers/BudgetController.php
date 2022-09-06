<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Sector;
use \App\Models\Budget;

class BudgetController extends Controller
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

        $year = request()->has('year') ? request()->get('year') : date('Y');
        $month = request()->has('month') ? request()->get('month') : date('m');
        $data = [
            'sectors' => [
                'incomes' => Sector::where('user_id', auth()->user()->id)->where('type', 'income')->orderBy('name', 'asc')->get(),
                'expenses' => Sector::where('user_id', auth()->user()->id)->where('type', 'expense')->orderBy('name', 'asc')->get(),
            ],
            'budget' => Budget::whereHas('sector', function($query){
                return $query->where('user_id', auth()->user()->id);
            })
            ->where('year', $year)
            ->where('month', $month)
            ->get()
        ];
        return view('budget.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('budget.create');
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

        $sector = Sector::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'type' => $request->type,
        ]);
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
            'sector' => Sector::find($id)
        ];
        return view('budget.edit', $data);
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

        $sector = Sector::updateOrCreate([
            'id' => $id
        ],[
            'name' => $request->name,
            'type' => $request->type,
        ]);
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
        if(Sector::find($id)->delete()){
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
