<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-chart-line"></i>&nbsp;&nbsp;{{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ url('dashboard') }}" method="get" accept-charset="utf-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="year"><strong>Year</strong></label>
                                            <select class="form-control select2bs4" name="year" id="year">
                                                @for($i=2022;$i<=2050;$i++)
                                                <option {{ $i == $year ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="month"><strong>Month</strong></label>
                                            <select class="form-control select2bs4" name="month" id="month">
                                                @for($i=1;$i<=12;$i++)
                                                <option value="{{ $i < 10 ? '0'.$i : $i }}" {{ $i == $month ? 'selected' : '' }}>{{ date('F', strtotime(date('Y-').($i < 10 ? '0'.$i : $i))) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <div class="form-group pt-2">
                                            <button type="submit" class="btn btn-success btn-block bg-success btn-md"><i class="fa fa-search"></i>&nbsp;Get Budget Report</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-success">
                                            <h1 class="text-white text-center" style="font-size: 20px;"><strong>Incomes</strong></h1>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-bordered p-0 mb-0">
                                                <thead>
                                                    <tr class="bg-info text-white">
                                                        <th style="width: 30%">Sector</th>
                                                        <th style="width: 25%">Budget</th>
                                                        <th style="width: 25%">Achievements</th>
                                                        <th style="width: 20%">Balance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $total_budget = 0;
                                                        $total_achievement = 0;
                                                        $total_balance = 0;
                                                    @endphp
                                                    @if(isset($sectors['incomes'][0]))
                                                    @foreach($sectors['incomes'] as $key => $income)
                                                    @php
                                                        $budget = getBudget($income->id, $year, $month);
                                                        $achievement = getEntry($income->id, $year, $month);
                                                        $balance = ($achievement-$budget['budget']);

                                                        $total_budget += $budget['budget'];
                                                        $total_achievement += $achievement;
                                                        $total_balance += $balance;
                                                    @endphp
                                                    <tr id="tr-{{ $income->id }}">
                                                        <td>{{ $income->name }}</td>
                                                        <td class="text-right">{{ $budget['budget'] }}</td>
                                                        <td class="text-right">{{ $achievement }}</td>
                                                        <td class="text-right {{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                                                            <strong>{{ $balance }}</strong>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td><strong>Total:</strong></td>
                                                        <td class="text-right">
                                                            <strong>{{ $total_budget }}</strong>
                                                        </td>
                                                        <td class="text-right">
                                                            <strong>{{ $total_achievement }}</strong>
                                                        </td>
                                                        <td class="text-right {{ $total_balance >= 0 ? 'text-success' : 'text-danger' }}">
                                                            <strong>{{ $total_balance }}</strong>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-danger">
                                            <h1 class="text-white text-center" style="font-size: 20px;"><strong>Expenses</strong></h1>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-bordered p-0 mb-0">
                                                <thead>
                                                    <tr class="bg-info text-white">
                                                        <th style="width: 30%">Sector</th>
                                                        <th style="width: 25%">Budget</th>
                                                        <th style="width: 25%">Consumptions</th>
                                                        <th style="width: 20%">Balance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $total_budget = 0;
                                                        $total_consumption = 0;
                                                        $total_balance = 0;
                                                    @endphp
                                                    @if(isset($sectors['expenses'][0]))
                                                    @foreach($sectors['expenses'] as $key => $expense)
                                                    @php
                                                        $budget = getBudget($expense->id, $year, $month);
                                                        $consumption = getEntry($expense->id, $year, $month);
                                                        $balance = ($budget['budget']-$consumption);

                                                        $total_budget += $budget['budget'];
                                                        $total_consumption += $consumption;
                                                        $total_balance += $balance;
                                                    @endphp
                                                    <tr id="tr-{{ $expense->id }}">
                                                        <td>{{ $expense->name }}</td>
                                                        <td class="text-right">{{ $budget['budget'] }}</td>
                                                        <td class="text-right">{{ $consumption }}</td>
                                                        <td class="text-right {{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                                                            <strong>{{ $balance }}</strong>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td><strong>Total:</strong></td>
                                                        <td class="text-right">
                                                            <strong>{{ $total_budget }}</strong>
                                                        </td>
                                                        <td class="text-right">
                                                            <strong>{{ $total_consumption }}</strong>
                                                        </td>
                                                        <td class="text-right {{ $total_balance >= 0 ? 'text-success' : 'text-danger' }}">
                                                            <strong>{{ $total_balance }}</strong>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
