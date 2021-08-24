@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'course'
])

@section('content')
    <div class="content">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <span class="float-left"><h5 class="card-title">{{ __('Course Management') }}</h5>
                            </div>
                            <div class="col-6">
                                <a href="course/create"><button type="button" class="btn btn-primary btn-round float-right">
                                <span class="fas fa-plus-circle"></span> Insert Data</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <div class="float-right">
                                    {{ $courses->links() }}
                                </div>
                            </div>
                        </div>
                        {{-- LIST OF COURSES --}}
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class=" text-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Mata Kuliah</th>
                                    <th scope="col">Kode Mata Kuliah</th>
                                    <th scope="col">SKS</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($courses as $c)
                                <tr>
                                    <td> {{ $loop->iteration + $courses->firstItem() - 1 }} </th>
                                    <td>{{ ucwords($c['name']) }}</td>
                                    <td>{{ strtoupper($c['course_code']) }}</td>
                                    <td>{{ $c['sks'] }}</td>
                                    <td>{{ $c['semester'] }}</td>
                                    <td>
                                    <form method="POST" action="course/{{$c->id}}">
                                        <a href="course/{{$c->id}}/edit"><button type="button" class="btn btn-outline-warning"><span class="fas fa-edit"></span></button></a>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-outline-danger"><span class="fas fa-trash"></span></button>       
                                    </form>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection