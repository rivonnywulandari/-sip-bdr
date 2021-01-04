<body>
    <header>
        <div>
            <img src="{{ asset('paper') }}/img/favicon.png" alt="Logo Unand">
            <h2>Universitas Andalas</h2>
            <h3>FAKULTAS TEKNOLOGI INFORMASI</h3>
        </div>
        <h2 class="text-center title">DAFTAR HADIR KULIAH</h2>
        <h4 class="text-center">Semester: {{ $classroom->period->period }}</h4>
    </header>

    <main>
    {{-- CLASSROOM INFORMATION --}}
        <table class="info">
            <tr>
                <td><strong>Kode/Mata Kuliah</strong></td>
                <td>:</td>
                <td>{{ $classroom->course->course }}</td>
            </tr>
            <tr>
                <td><strong>Kode Kelas</strong></td>
                <td>:</td>
                <td>{{ $classroom->classroom_code }}</td>
            </tr>
            <tr>
                <td><strong>Dosen Pengampu</strong></td>
                <td>:</td>
                @foreach($lecturers as $lecturer)
                @if($loop->iteration > 1)
                <tr>
                    <td></td>
                    <td></td>
                @endif
                <td>{{ $lecturer->lecturer->name }}</td>
                </tr>
                @endforeach
            </tr>
        </table>
        
        {{-- LIST OF ATTENDEES --}}
        <table class="real-table">
            <thead>
                 <tr class="real-table">
                    <th class="real-table">No</th>
                    <th class="real-table">NIM</th>
                    <th class="real-table">Nama</th>
                    @foreach($date_temp as $temp)
                    <?php
                        $date = explode("-", $temp['date']);
                        $date = $date[2]."/".$date[1];
                    ?>
                    <th class="real-table">{{ $date }}</th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
            @foreach($presence as $p)
                <tr class="real-table">
                    <td class="real-table text-center "> {{ $loop->iteration }} </td>
                    <td class="real-table">{{ $p['nim'] }}</td>
                    <td class="real-table">{{ $p['student_name'] }}</td>
                        @foreach ($p['desc'] as $key => $item)
                            @foreach ($p['desc'] as $i)

                                @if ($date_temp[$key]['date'] == $i['date'])

                                    @if ($item['presence_status'] == 'Hadir')
                                    <td class="real-table text-center">v</td>
                                    @elseif ($item['presence_status'] == 'Izin')
                                    <td class="real-table text-center">i</td>
                                    @else
                                    <td class="real-table text-center">-</td>
                                    @endif

                                @endif

                            @endforeach
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>    
    </main>
</body>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');

    body {
        font-family: 'Open Sans', sans-serif;
    }

    img {
        width: 60px;
        height: 60px;
        float: left;
    }

    h2, h3, h4 {
        margin: 0;
    }

    .title {
        margin: 15px auto 5px;
    }

    .text-center {
        text-align: center;
    }

    .info {
        margin-top: 10px;
    }

    .real-table {
        border: 1px solid;
        border-collapse:collapse;
        padding: 5px;
        margin-top: 10px;
    }

    .real-table th {
        background-color: #D3D3D3
    }

</style>

<script>window.print();</script>
