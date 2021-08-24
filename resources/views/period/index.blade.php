@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'period'
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
                                <span class="float-left"><h5 class="card-title">{{ __('Period Management') }}</h5>
                            </div>
                            <div class="col-6">
                                <a href="period/create"><button type="button" class="btn btn-primary btn-round float-right">
                                <span class="fas fa-plus-circle"></span> Insert Data</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <div class="float-right">
                                    {{ $periods->links() }}
                                </div>
                            </div>
                        </div>
                        {{-- LIST OF PERIODS --}}
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class=" text-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Tahun</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($periods as $p)
                                <tr>
                                    <td> {{ $loop->iteration + $periods->firstItem() - 1 }} </th>
                                    <td>{{ $p['year'] }}</td>
                                    <td>{{ $p['semester'] }}</td>
                                    <td>
                                    <form method="POST" action="period/{{$p->id}}">
                                        <a href="period/{{$p->id}}/edit"><button type="button" class="btn btn-outline-warning"><span class="fas fa-edit"></span></button></a>
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