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
                        <h5 class="card-title">Detail Kelas</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <p class="col-sm-2 text-primary"><strong>Nama Mata Kuliah</strong></p>
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

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class=" text-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">NIM</th>
                                    @foreach($attendances as $attendance)
                                    <?php
                                        $date = explode("-", $attendance->meeting->date);
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
                                    <td>{{ $p['student_name'] }}</td>
                                    <td>{{ $p['nim'] }}</td>
                                    @foreach ($p['desc'] as $key => $item)
                                        @foreach ($p['desc'] as $i)

                                        @if ($date_temp[$key]['date'] == $i['date'])

                                            <td>{{ $item['presence_status'] }}</td>

                                        @endif

                                        @endforeach
                                    @endforeach
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
