<html>
<head>
    <script src="{{ asset('paper') }}/js/core/jquery.min.js"></script>
</head>
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

    <main id="main">
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
        <table id="table-1" class="real-table">
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
                                    <td class="real-table text-center"><p class="present">v</p></td>
                                    @elseif ($item['presence_status'] == 'Izin')
                                    <td class="real-table text-center"><p class="permit">i</p></td>
                                    @else
                                    <td class="real-table text-center"><p class="absent">x</p></td>
                                    @endif

                                @endif

                            @endforeach
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>   
        <button id="print-btn" class="floating-btn">Print</button>
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
        font-size: 13px;
    }

    .real-table th {
        background-color: #D3D3D3
    }

    .present {
        color: green;
    }

    .permit {
        color: orange;
    }

    .absent {
        color: red;
    }

    .floating-btn {
        display: block;
        width: 90px;
        height: 35px;
        line-height: 35px;
        text-align: center;
        color: white;
        background-color: #51cbce;
        font-size: 15px;
        border:1px solid transparent;
        border-radius: 30px;
        -webkit-border-radius: 30px;
        transition: ease all 0.3s;
        position: absolute;
        right: 30px;
        top:30px;
        font-family: 'Open Sans', sans-serif;
    }
</style>

<script>
    $("#print-btn").on("click", function() {
        var table = $("#table-1"),
            tableWidth = table.outerWidth(),
            pageWidth = 936,
            pageCount = Math.ceil(tableWidth / pageWidth),
            printWrap = $("<div></div>").insertAfter(table),
            i,
            printPage;

        $("#print-btn").remove();

        var positions = [];
        var lastOuterWidth = 0;
        $("#table-1 th").each(function() {
            positions.push($(this).position().left);
            lastOuterWidth = $(this).outerWidth;
        });

        var pageWidths = [];
        var endColumns = [];

        var lastPosition = 0;
        for (i = 1; i < positions.length; i++) {
            if ((positions[i] - lastPosition) > pageWidth) {
                pageWidths.push(positions[i - 1] - lastPosition);
                lastPosition = positions[i - 1];
                endColumns.push(i - 1);
            }
            if (i == (positions.length - 1)) {
                pageWidths.push(positions[i] + lastOuterWidth - lastPosition);
                lastPosition = positions[i];
                endColumns.push(i);
            }
        }
        pageCount = pageWidths.length;

        var lastEndColumn = 0;
        for (i = 0; i < pageCount; i++) {
            var thisPageWidth = pageWidth;
            var styleString = "overflow: hidden; width:" + thisPageWidth + "px; page-break-before: " + (i === 0 ? "auto" : "always") + ";";
            var newTable = table.clone().attr("id", "table-page-" + i);
            newTable.attr("style", styleString);
            newTable.appendTo("#main");

            //remove columns either side of our page
            for (var j = positions.length - 1; j >= 0; j--) {
                if (j > endColumns[i] || j <= lastEndColumn) {
                    var index = j + 1;
                    var heading = $(newTable).find("tr th:nth-child(" + index + ")");
                    $(newTable).find("tr th:nth-child(" + index + ")").remove();
                    $(newTable).find("tr td:nth-child(" + index + ")").remove();
                }
            }

            lastEndColumn = endColumns[i];
        }

        table.hide();
        $(this).prop("disabled", true);

        window.print();
    });
</script>
