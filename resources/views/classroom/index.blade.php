@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'classroom'
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
        @elseif ($errors->any())
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
                        <div class="row">
                            <div class="col-6">
                                <span class="float-left"><h5 class="card-title">{{ __('Class Management') }}</h5>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary btn-round float-right" 
                                    data-toggle="modal" data-target="#importExcel">
                                    <span class="fas fa-plus-circle"></span> Import Data
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Import Excel -->
                    <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="importModal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="post" action="{{ url('classroom/import') }}" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="importModal">Import Excel</h5>
                                    </div>
                                    <div class="modal-body">
                                        {{ csrf_field() }}
            
                                        <p>Pilih file excel</p>
                                        <div class="control-group">
                                            <input type="file" name="report_file" required="required">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Import</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <div class="float-right">
                                    {{ $classrooms->links() }}
                                </div>
                            </div>
                        </div>
                        {{-- LIST OF CLASSROOMS --}}
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class=" text-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Kelas</th>
                                    <th scope="col">Kode Kelas</th>
                                    <th scope="col">Periode</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($classrooms as $c)
                                <tr>
                                    <td> {{ $loop->iteration + $classrooms->firstItem() - 1 }} </th>
                                    <td>{{ ucwords($c->course->name) }}</td>
                                    <td>{{ $c['classroom_code'] }}</td>
                                    <td>{{ $c->period->period }}</td>
                                    <td>
                                    <form method="POST" action="classroom/{{$c->id}}">
                                        <a href="classroom/{{$c->id}}/show"><button  type="button" class="btn btn-outline-primary"><span class="fas fa-eye"></span></button></a>
                                        <a href="classroom/{{$c->id}}/edit"><button type="button" class="btn btn-outline-warning"><span class="fas fa-edit"></span></button></a>
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