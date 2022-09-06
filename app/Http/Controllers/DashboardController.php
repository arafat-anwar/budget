<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Sector;
use \App\Models\Budget;
use \App\Models\Entry;

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
                'incomes' => Sector::where('user_id', auth()->user()->id)->where('type', 'income')->orderBy('name', 'asc')->get(),
                'expenses' => Sector::where('user_id', auth()->user()->id)->where('type', 'expense')->orderBy('name', 'asc')->get(),
            ],
        ];
        return view('dashboard', $data);
    }
}
