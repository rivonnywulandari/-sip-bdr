<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">Tahun Ajaran</p>
    <div class="col-sm-6">
    {{ Form::text('year', null, ['class' => 'form-control', 'name' => 'year', 'placeholder' => 'Contoh: 2021/2022']) }}
    </div>
    <div class="col-sm-2"></div>
</div>

<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">Semester</p>
    <div class="col-sm-6">
    {{ Form::select('semester', $semesters, null, ['class' => 'form-control', 'name' => 'semester', 'placeholder' => 'Semester']) }}
    </div>
    <div class="col-sm-2"></div>
</div>