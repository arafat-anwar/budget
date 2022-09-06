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
    
    public function index()
    {
        $year = request()->has('year') ? request()->get('year') : date('Y');
        $month = request()->has('month') ? request()->get('month') : date('m');
        $data = [
            'year' => $year,
            'month' => $month,
            'sectors' => [
                'incomes' => Sector::where('user_id', auth()->user()->id)->where('type', 'income')->orderBy('name', 'asc')->get(),
                'expenses' => Sector::where('user_id', auth()->user()->id)->where('type', 'expense')->orderBy('name', 'asc')->get(),
            ],
            'budgets' => Budget::whereHas('sector', function($query){
                return $query->where('user_id', auth()->user()->id);
            })
            ->where('year', $year)
            ->where('month', $month)
            ->get()
        ];
        return view('budget.index', $data);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'month' => 'required',
            'amounts' => 'required',
            'amounts.*' => 'required',
            'remarks' => 'required',
            'remarks.*' => 'required',
        ]);
        
        foreach($request->amounts as $sector_id => $value){
            Budget::updateOrCreate([
                'sector_id' => $sector_id,
                'year' => $request->year,
                'month' => $request->month,
            ],[
                'budget' => $request->amounts[$sector_id],
                'remarks' => $request->remarks[$sector_id],
            ]);
        }

        success("Monthly Budget Has been Saved Successfully");
        return redirect()->back();
    }
}
