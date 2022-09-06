<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-money-bill-alt"></i>&nbsp;&nbsp;Entries
            <a class="btn btn-success btn-sm" onclick="Show('New Entry', '{{ url('entries/create') }}')" style="cursor: pointer;float: right"><i class="fa fa-plus"></i>&nbsp;New Entry</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding-left: 20px !important;padding-right: 20px !important">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200">
                    <div class="row p-3">
                        <div class="col-md-12">
                            <form action="{{ url('entries') }}" method="get" accept-charset="utf-8">
                                <div class="row">
                                    <div class="col-md-4 pt-2">
                                      <label for="sector_id"><strong>Sector :</strong></label>
                                      <select name="sector_id" id="sector_id" class="form-control select2bs4">
                                        <optgroup label="">
                                            <option value="0">All Sectors</option>
                                        </optgroup>
                                        <optgroup label="Income">
                                          @if(isset($sectors['incomes'][0]))
                                          @foreach($sectors['incomes'] as $key => $income)
                                          <option value="{{ $income->id }}">&nbsp;&nbsp;&nbsp;&nbsp;{{ $income->name }}</option>
                                          @endforeach
                                          @endif
                                        </optgroup>
                                        <optgroup label="Expense">
                                          @if(isset($sectors['expenses'][0]))
                                          @foreach($sectors['expenses'] as $key => $expense)
                                          <option value="{{ $expense->id }}">&nbsp;&nbsp;&nbsp;&nbsp;{{ $expense->name }}</option>
                                          @endforeach
                                          @endif
                                        </optgroup>
                                      </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="from"><strong>From</strong></label>
                                            <x-input id="from" class="block mt-1 w-full" type="date" name="from" value="{{ $from }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="to"><strong>To</strong></label>
                                            <x-input id="to" class="block mt-1 w-full" type="date" name="to" value="{{ $to }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-2 pt-4">
                                        <div class="form-group pt-3">
                                            <button type="submit" class="btn btn-success btn-block bg-success btn-md"><i class="fa fa-search"></i>&nbsp;Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered pb-0 mb-0">
                                <thead>
                                    <tr class="bg-info text-white">
                                        <th style="width: 5%">SL</th>
                                        <th style="width: 20%">Sector</th>
                                        <th style="width: 30%">Title</th>
                                        <th style="width: 15%">Amount</th>
                                        <th style="width: 20%">Date & Time</th>
                                        <th style="width: 10%" class="text-center">Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($entries[0]))
                                    @foreach($entries as $key => $entry)
                                    <tr id="tr-{{ $entry->id }}">
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $entry->sector->name }} (<span class="{{ $entry->sector->type == 'income' ? 'text-success' : 'text-danger' }}">{{ ucwords($entry->sector->type) }}</span>)</td>
                                        <td>{{ $entry->title }}</td>
                                        <td class="text-right">{{ $entry->amount }}</td>
                                        <td>{{ date('F j, Y', strtotime($entry->time)).' '.date('g:i a', strtotime($entry->time)) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                              <a onclick="Show('Edit Sector', '{{ url('entries/'.$entry->id.'/edit') }}')" style="cursor: pointer" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                              <a class="btn btn-sm btn-danger" onclick="Delete('{{ $entry->id }}','{{ url('entries') }}')"><i class="fa fa-trash text-white"></i></a>
                                            </div>
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
    </div>
</x-app-layout>
