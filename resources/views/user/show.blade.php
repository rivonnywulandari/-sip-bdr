@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'user'
])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('User Detail') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <p class="col-sm-3 text-primary"><strong>Nama</strong></p>
                            @if (isset($user->lecturer->name))
                                <p class="col-sm-9">{{ $user->lecturer->name }}</p>
                            @elseif (isset($user->student->name))
                                <p class="col-sm-9">{{ $user->student->name }}</p>
                            @endif
                        </div>
                        <div class="form-group row">
                        @if (isset($user->lecturer->nip))
                            <p class="col-sm-3 text-primary"><strong>NIP</strong></p>
                            <p class="col-sm-9">{{ $user->lecturer->nip }}</p>
                        @elseif (isset($user->student->name))
                            <p class="col-sm-3 text-primary"><strong>NIM</strong></p>
                            <p class="col-sm-9">{{ $user->student->nim }}</p>
                        @endif
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 text-primary"><strong>Username</strong></p>
                            <p class="col-sm-9">{{ $user->username }}</p>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 text-primary"><strong>Email</strong></p>
                            <p class="col-sm-9">{{ $user->email }}</p>
                        </div>
                        @if (isset($user->student->lecturer_id))
                        <div class="form-group row">
                            <p class="col-sm-3 text-primary"><strong>Dosen PA</strong></p>
                            <p class="col-sm-9">{{ $user->student->lecturer->name }}</p>
                        </div>
                        @elseif (isset($user->lecturer->id))
                        <div class="form-group row">
                            <p class="col-sm-3 text-primary"><strong>Mahasiswa Bimbingan</strong></p>
                            @foreach($guidance_students as $gd)
                                @if($loop->iteration > 1)
                                <div class="col-sm-3"></div>
                                @endif
                            <p class="col-sm-9">{{ $gd->name }}</p>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection