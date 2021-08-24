@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'classroom'
])

@section('content')
    <div class="content">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Edit Class') }}</h5>
                    </div>
                    
                    {{ Form::model($classroom, ['route' => ['classroom.update', $classroom->id], 'method' => 'patch']) }}
                    {{ csrf_field() }}

                    <div class="card-body">
                        @include('classroom.edit_form')                
                        <div class="col-10">
                            <input type="submit" value="Save Changes" class="btn btn-primary btn-round float-right mb-3"/>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection