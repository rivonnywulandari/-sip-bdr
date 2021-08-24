@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'classroom'
])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ ucwords($classroom->course->name) }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <p class="col-sm-2 text-primary"><strong>Kode/Mata Kuliah</strong></p>
                            <p class="col-sm-5">{{ $classroom->course->course }}</p>
                            <p class="col-sm-2 text-primary"><strong>Periode</strong></p>
                            <p class="col-sm-3">{{ $classroom->period->period }}</p>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-2 text-primary"><strong>Kode Kelas</strong></p>
                            <p class="col-sm-5">{{ $classroom->classroom_code }}</p>
                            <p class="col-sm-2 text-primary"><strong>Semester</strong></p>
                            <p class="col-sm-3">{{ $classroom->course->semester }}</p>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-2 text-primary"><strong>Dosen Pengampu</strong></p>
                            @foreach($lecturers as $lecturer)
                                @if($loop->iteration > 1)
                                <div class="col-sm-2"></div>
                                @endif
                            <p class="col-sm-10">{{ $lecturer->lecturer->name }}</p>
                            @endforeach
                        </div>

                        {{-- LIST OF ATTENDEES --}}
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class=" text-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Nama</th>
                                    @foreach($date_temp as $temp)
                                    <?php
                                        $date = explode("-", $temp['date']);
                                        $date = $date[2]."/".$date[1];
                                    ?>
                                    <th scope="col">{{ $date }}</th>
                                    @endforeach
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($presence as $p)
                                <tr>
                                    <td> {{ $loop->iteration }} </th>
                                    <td>{{ $p['nim'] }}</td>
                                    <td>{{ $p['student_name'] }}</td>
                                    @foreach ($p['desc'] as $key => $item)
                                        @foreach ($p['desc'] as $i)

                                        @if ($date_temp[$key]['date'] == $i['date'])

                                        @if ($item['presence_status'] == 'Hadir')
                                        <td class="text-center"><p class="text-success" data-toggle="tooltip" title="Hadir">v</p></td>
                                        @elseif ($item['presence_status'] == 'Izin')
                                        <td class="text-center"><p class="text-warning" data-toggle="tooltip" title="Izin">i</p></td>
                                        @else
                                        <td class="text-center"><p class="text-danger" data-toggle="tooltip" title="Absen">x</p></td>
                                        @endif

                                        @endif

                                        @endforeach
                                    @endforeach
                                </tr>
                                @endforeach
                                </tbody>
                            </table>    
                        </div>
                        
                        {{-- PRINT BUTTON --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <a class="floating-btn btn-primary" target="blank" href="{{ route('classroom.show', ['id' => Request::segment(2), 'action' => 'print']) }}">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </div>
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
        $( document ).ready(function() {
            $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
        });
    </script>
@endpush