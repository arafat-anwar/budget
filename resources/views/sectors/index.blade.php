<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-bezier-curve"></i>&nbsp;&nbsp;Sectors
            <a class="btn btn-success btn-sm" onclick="Show('New Sector', '{{ url('sectors/create') }}')" style="cursor: pointer;float: right"><i class="fa fa-plus"></i>&nbsp;New Sector</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding-left: 20px !important;padding-right: 20px !important">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200">
                    <table class="table table-bordered pb-0 mb-0">
                        <thead>
                            <tr class="bg-info text-white">
                                <th style="width: 5%">SL</th>
                                <th style="width: 70%">Sector Name</th>
                                <th style="width: 15%" class="text-center">Type</th>
                                <th style="width: 10%" class="text-center">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($sectors[0]))
                            @foreach($sectors as $key => $sector)
                            <tr id="tr-{{ $sector->id }}">
                                <td>{{ $key+1 }}</td>
                                <td>{{ $sector->name }}</td>
                                <td class="text-center {{ $sector->type == 'income' ? 'text-success' : 'text-danger' }}"><strong>{{ ucwords($sector->type) }}</strong></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                      <a onclick="Show('Edit Sector', '{{ url('sectors/'.$sector->id.'/edit') }}')" style="cursor: pointer" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                      <a class="btn btn-sm btn-danger" onclick="Delete('{{ $sector->id }}','{{ url('sectors') }}')"><i class="fa fa-trash text-white"></i></a>
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
</x-app-layout>
