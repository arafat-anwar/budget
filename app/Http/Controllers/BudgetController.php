<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Sector;
use \App\Models\Budget;
use DB;

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
                'incomes' => DB::select("select * from `sectors` where `user_id` = ".auth()->user()->id." and type = 'income' order by name asc"),
                'expenses' => DB::select("select * from `sectors` where `user_id` = ".auth()->user()->id." and type = 'expense' order by name asc"),
            ]
        ];
        return view('budget.index', $data);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'month' => 'required',
            'amounts' => 'required',
            'remarks' => 'required',
        ]);
        
        foreach($request->amounts as $sector_id => $value){
            if(!empty($value)){
                $search = DB::select("select * from `budget` where (`sector_id` = '".$sector_id."' and `year` = '".$request->year."' and `month` = '".$request->month."') limit 1");
                if(isset($search[0]->id)){
                    DB::select("update `budget` set `budget` = '".$request->amounts[$sector_id]."', `remarks` = '".$request->remarks[$sector_id]."' where `id` = '".$search[0]->id."'");
                }else{
                    DB::select("INSERT INTO `budget` (`sector_id`, `year`, `month`, `budget`, `remarks`) VALUES ('".$sector_id."', '".$request->year."', '".$request->month."', '".$request->amounts[$sector_id]."', '".$request->remarks[$sector_id]."')");
                }
            }
        }

        success("Monthly Budget Has been Saved Successfully");
        return redirect()->back();
    }
}
