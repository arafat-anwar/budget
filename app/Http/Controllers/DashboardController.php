<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Sector;
use \App\Models\Budget;
use \App\Models\Entry;
use DB;

class DashboardController extends Controller
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
        return view('dashboard', $data);
    }
}
