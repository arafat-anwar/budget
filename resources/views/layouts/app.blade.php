<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Budget</title>
        <link rel="icon" href="{{ asset('icon.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.1/css/all.min.css"/>
        
        <link rel="stylesheet" href="{{asset('lte')}}/jquery-confirm/jquery-confirm.min.css">
        <link rel="stylesheet" href="{{asset('lte')}}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{asset('lte')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{asset('lte')}}/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <link rel="stylesheet" href="{{asset('lte')}}/wnoty/wnoty.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <style type="text/css">
            a:hover{
                text-decoration: none !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
                @include('layouts.modals')
            </main>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>

            <script src="{{asset('lte')}}/jquery-confirm/jquery-confirm.min.js"></script>
            <script src="{{asset('lte')}}/plugins/select2/js/select2.full.min.js"></script>
            <script src="{{asset('lte')}}/wnoty/wnoty.js"></script>

            <script src="{{asset('lte')}}/bootstrap-datetimepicker/moment.min.js" ></script>
            <script src="{{asset('lte')}}/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

            @if(session()->has('success'))
            <script type="text/javascript">
                $(document).ready(function() {
                    notify('{{session()->get('success')}}','success');
                });
            </script>
            @endif

            @if(session()->has('danger'))
            <script type="text/javascript">
                $(document).ready(function() {
                    notify('{{session()->get('danger')}}','danger');
                });
            </script>
            @endif

            @if($errors->any())
            <script type="text/javascript">
                $(document).ready(function() {
                    var errors=<?php echo json_encode($errors->all()); ?>;
                    $.each(errors, function(index, val) {
                        notify(val,'danger');
                    });
                });
            </script>
            @endif

            <script type="text/javascript">
                var base_url = "{{ url('/') }}";

                $(document).ready(function() {
                    $('input').attr('autocomplete','off');
                    
                    $('.select2').select2();
                    $('.select2bs4').select2({
                        theme: 'bootstrap4'
                    });
                    
                    $('.select2-tags').select2({
                        tags: true,
                        width: '100%'
                    });
                    $('.select2bs4-tags').select2({
                        theme: 'bootstrap4',
                        tags: true,
                        width: '100%'
                    });

                    $('.select2-modal').select2({
                        dropdownParent: $("#modal")
                    });
                    $('.select2bs4-modal').select2({
                        theme: 'bootstrap4',
                        dropdownParent: $("#modal")
                    });
                    
                    $('.datetimepicker').datetimepicker();
                    
                    $('.datepicker').datetimepicker({
                        format: 'YYYY-MM-DD',
                    });
                    
                    $('.yearpicker').datetimepicker({
                        format: 'YYYY',
                    });
                    
                    $('.timepicker').datetimepicker({
                        format: 'LT'
                    });
                    
                    $('input[name="daterange"]').daterangepicker({
                        autoUpdateInput: false,
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yeasterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'Current Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                            'Current Year': [moment().startOf('year'), moment().endOf('year')],
                            'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                        },
                        locale: {
                            cancelLabel: 'Clear',
                            applyLabel: 'Ok',
                            format: 'YYYY-MM-DD'
                        }
                    });
                    
                    $('input[name="daterange"]').attr('autocomplete','off');
                    
                    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                    });
                    
                    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                        $(this).val('');
                    });
                    
                    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                    });
                    
                    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                        $(this).val('');
                    });
                });
                
                function Show(title,link,style = '') {
                    $('#modal').modal('toggle');
                    $('#modal-title').html(title);
                    $('#modal-body').html('<h1 class="text-center"><strong>Please Wait...</strong></h1>');
                    $('#modal-dialog').attr('style',style);
                    $.ajax({
                        url: link,
                        type: 'GET',
                        data: {},
                    })
                    .done(function(response) {
                        $('#modal-body').html(response);
                    });
                }
                
                
                function Popup(title,link) {
                    $.dialog({
                        title: title,
                        content: 'url:'+link,
                        animation: 'scale',
                        columnClass: 'large',
                        closeAnimation: 'scale',
                        backgroundDismiss: true,
                    });
                }

                function PopupWithContent(title,content) {
                    $.dialog({
                        title: title,
                        content: content,
                        animation: 'scale',
                        columnClass: 'large',
                        closeAnimation: 'scale',
                        backgroundDismiss: true,
                    });
                }
                
                function ToggleStatus(button, table, id){
                    $.confirm({
                        title: 'Confirm!',
                        content: '<hr><div class="alert alert-danger">Are you sure ?</div><hr>',
                        buttons: {
                            yes: {
                                text: 'Yes',
                                btnClass: 'btn-success',
                                action: function(){
                                    $.ajax({
                                        url: "{{ url('dashboard/toggle-status') }}",
                                        type: 'POST',
                                        data: {_token: "{{ csrf_token() }}", table:table, id:id},
                                    })
                                    .done(function(response) {
                                        if(response.success){
                                            button.removeClass(response.old_class);
                                            button.addClass(response.new_class);
                                            button.html(response.new_text);
                                            notify(response.message,'success');
                                            }else{
                                            notify(response.message,'danger');
                                        }
                                    })
                                    .fail(function(response){
                                        notify('Something went wrong!','danger');
                                    });
                                }
                            },
                            no: {
                                text: 'No',
                                btnClass: 'btn-default',
                                action: function(){
                                    
                                }
                            }
                        }
                    });
                }
                
                function Delete(id,link) {
                    $.confirm({
                        title: 'Confirm',
                        content: '<hr><div class="alert alert-danger mt-3">Are you sure to Delete ?</div><hr>',
                        buttons: {
                            yes: {
                                text: 'Yes',
                                btnClass: 'bg-danger text-white btn-danger',
                                action: function(){
                                    $.ajax({
                                        url: link+"/"+id,
                                        type: 'DELETE',
                                        data: {_token:"{{ csrf_token() }}"},
                                    })
                                    .done(function(response) {
                                        if(response.success){
                                            $('#tr-'+id).fadeOut();
                                            notify('Data has been deleted','success');
                                        }else{
                                            notify('Something went wrong!','danger');
                                        }
                                    })
                                    .fail(function(response){
                                        notify('Something went wrong!','danger');
                                    });
                                }
                            },
                            no: {
                                text: 'No',
                                btnClass: 'btn-default',
                                action: function(){
                                    
                                }
                            }
                        }
                    });
                }
                
                function notify(message,type) {
                    $.wnoty({
                        message: '<strong class="text-'+(type)+'">'+(message)+'</strong>',
                        type: type,
                        autohideDelay: 3000
                    });
                }
                
                function playTone(which) {
                    var sound = "{{auth()->check() ? auth()->user()->sound : 0}}";
                    if(sound == 1){
                        var obj = document.createElement("audio");
                        obj.src = "{{asset('lte/tones')}}/"+(which)+".mp3"; 
                        obj.play(); 
                    }
                }
                
                function openLink(link,type='_parent'){
                    window.open(link,type);
                }
            </script>
        </div>
    </body>
</html>
