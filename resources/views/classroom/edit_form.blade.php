<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">Mata Kuliah</p>
    <div class="col-sm-6">
    {{ Form::select('course_id', $courses, null, ['class' => 'form-control', 'name' => 'course_id', 'placeholder' => 'Mata Kuliah']) }}
    </div>
    <div class="col-sm-2"></div>
</div>

<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">Kode Kelas</p>
    <div class="col-sm-6">
    {{ Form::select('classroom_code', $codes, $classroom->classroom_code, ['class' => 'form-control', 'name' => 'classroom_code', 'placeholder' => 'Kode Kelas']) }}
    </div>
    <div class="col-sm-2"></div>
</div>

<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">Periode</p>
    <div class="col-sm-6">
    {{ Form::select('period_id', $periods, null, ['class' => 'form-control', 'name' => 'period_id', 'placeholder' => 'Periode']) }}
    </div>
    <div class="col-sm-2"></div>
</div>