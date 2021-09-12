<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">Username</p>
    <div class="col-sm-6">
    {{ Form::text('username', null, ['class' => 'form-control', 'name' => 'username', 'placeholder' => 'Username']) }}
    </div>
    <div class="col-sm-2"></div>
</div>

<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">Email</p>
    <div class="col-sm-6">
    {{ Form::email('email', null, ['class' => 'form-control', 'name' => 'email', 'placeholder' => 'Email']) }}
    </div>
    <div class="col-sm-2"></div>
</div>

@if (isset($user->lecturer->id))
<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">Nama</p>
    <div class="col-sm-6">
    {{ Form::text('name', $user->lecturer->name, ['class' => 'form-control', 'name' => 'name', 'placeholder' => 'Nama']) }}
    </div>
    <div class="col-sm-2"></div>
</div>
<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">NIP</p>
    <div class="col-sm-6">
    {{ Form::text('nip', $user->lecturer->nip, ['class' => 'form-control', 'name' => 'nip', 'placeholder' => 'NIP']) }}
    </div>
    <div class="col-sm-2"></div>
</div>
@elseif (isset($user->student->id))
<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">Nama</p>
    <div class="col-sm-6"> 
    {{ Form::text('name', $user->student->name, ['class' => 'form-control', 'name' => 'name', 'placeholder' => 'Nama']) }}
    </div>
    <div class="col-sm-2"></div>
</div>
<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">NIM</p>
    <div class="col-sm-6">
    {{ Form::text('nim', $user->student->nim, ['class' => 'form-control', 'name' => 'nim', 'placeholder' => 'NIM']) }}
    </div>
    <div class="col-sm-2"></div>
</div>

<div class="form-group row">
    <div class="col-sm-2"></div>
    <p class="col-sm-2 col-form-label">Dosen PA</p>
    <div class="col-sm-6">
    {{ Form::select('lecturer_id', $lecturers, $user->student->lecturer_id, ['class' => 'form-control', 'name' => 'lecturer_id', 'placeholder' => 'Dosen PA']) }}
    </div>
    <div class="col-sm-2"></div>
</div>
@endif