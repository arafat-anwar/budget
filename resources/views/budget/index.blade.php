<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-hand-holding-usd"></i>&nbsp;&nbsp;Monthly Budgets
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding-left: 20px !important;padding-right: 20px !important">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200">
                    <div class="row p-3">
                        <div class="col-md-12">
                            <form action="{{ url('budget') }}" method="get" accept-charset="utf-8">
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
                                            <label for="month"><strong>month</strong></label>
                                            <select class="form-control select2bs4" name="month" id="month">
                                                @for($i=1;$i<=12;$i++)
                                                <option value="{{ $i < 10 ? '0'.$i : $i }}" {{ $i == $month ? 'selected' : '' }}>{{ date('F', strtotime(date('Y-').($i < 10 ? '0'.$i : $i))) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <div class="form-group pt-2">
                                            <button type="submit" class="btn btn-success btn-block bg-success btn-md"><i class="fa fa-search"></i>&nbsp;Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <form action="{{ route('budget.store') }}" method="post" accept-charset="utf-8">
                        @csrf
                        <input type="hidden" name="year" value="{{ $year }}">
                        <input type="hidden" name="month" value="{{ $month }}">
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
                                                            <th style="width: 35%">Sector</th>
                                                            <th style="width: 25%">Budget</th>
                                                            <th style="width: 40%">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($sectors['incomes'][0]))
                                                        @foreach($sectors['incomes'] as $key => $income)
                                                        @php
                                                            $budget = getBudget($income->id, $year, $month);
                                                        @endphp
                                                        <tr id="tr-{{ $income->id }}">
                                                            <td>{{ $income->name }}</td>
                                                            <td>
                                                                <x-input class="block mt-1 w-full" type="number" name="amounts[{{ $income->id }}]" value="{{ $budget['budget'] }}" />
                                                            </td>
                                                            <td>
                                                                <x-input class="block mt-1 w-full" type="text" name="remarks[{{ $income->id }}]" value="{{ $budget['remarks'] }}" />
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                    </tbody>
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
                                                            <th style="width: 35%">Sector</th>
                                                            <th style="width: 25%">Budget</th>
                                                            <th style="width: 40%">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($sectors['expenses'][0]))
                                                        @foreach($sectors['expenses'] as $key => $expense)
                                                        @php
                                                            $budget = getBudget($expense->id, $year, $month);
                                                        @endphp
                                                        <tr id="tr-{{ $expense->id }}">
                                                            <td>{{ $expense->name }}</td>
                                                            <td>
                                                                <x-input class="block mt-1 w-full" type="number" name="amounts[{{ $expense->id }}]" value="{{ $budget['budget'] }}" />
                                                            </td>
                                                            <td>
                                                                <x-input class="block mt-1 w-full" type="text" name="remarks[{{ $expense->id }}]" value="{{ $budget['remarks'] }}" />
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 pt-4">
                                <div class="row">
                                    <div class="col-md-4 offset-md-4">
                                        <button type="submit" class="btn btn-success bg-success btn-block"><i class="fa fa-save"></i>&nbsp;&nbsp;Save Monthly Budget</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
