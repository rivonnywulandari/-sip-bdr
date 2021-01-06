@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'dashboard'
])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Dashboard') }}</h5>
                    </div>
                    <div class="card-body">
                        <form class="form" method="POST" action="{{ route('dashboard.store') }}">
                            @csrf

                            <div class="form-group row">
                                <p class="ml-3 mt-2 align-middle">Periode</p>
                                <div class="col-sm-3">
                                    <select class="form-control" id="period" name="period">
                                    <option selected>Pilih Periode</option>
                                        @foreach ($periods as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach 
                                    </select> 
                                </div>
                                <p class="ml-3 mt-2 align-middle">Kelas</p>
                                <div class="col-sm-5">
                                    <select class="form-control" id="classroom" name="classroom">
                                    <option selected>Pilih Kelas</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-round mt-0">
                                    <i class="nc-icon nc-zoom-split"></i>{{ __(' Tampilkan Kelas') }}</button>       
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-6">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        jQuery(document).ready(function () {
            jQuery('select[name="period"]').on('change', function(){
               var period_id = jQuery(this).val();
               if(period_id)
               {
                  jQuery.ajax({
                     url : 'dashboard/classrooms/' +period_id,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="classroom"]').empty();
                        jQuery.each(data, function(key,value){
                            value = capitalize(value);
                           $('select[name="classroom"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="classroom"]').empty();
               }
            });
        });

        function capitalize(input) {  
            return input.toLowerCase().split(' ').map(s => s.charAt(0).toUpperCase() + s.substring(1)).join(' ');  
        }  
    </script>
@endpush