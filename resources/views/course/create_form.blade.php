<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">Nama Mata Kuliah</p>
    <div class="col-sm-6">
    {{ Form::text('name', null, ['class' => 'form-control', 'name' => 'name', 'placeholder' => 'Nama Mata Kuliah']) }}
    </div>
    <div class="col-sm-2"></div>
</div>

<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">Kode Mata Kuliah</p>
    <div class="col-sm-6">
    {{ Form::text('course_code', null, ['class' => 'form-control', 'name' => 'course_code', 'placeholder' => 'Kode Mata Kuliah']) }}
    </div>
    <div class="col-sm-2"></div>
</div>

<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">Jumlah SKS</p>
    <div class="col-sm-6">
    {{ Form::select('sks', $sks, null, ['class' => 'form-control', 'name' => 'sks', 'placeholder' => 'Jumlah SKS']) }}
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