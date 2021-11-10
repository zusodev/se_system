@csrf
<div class="form-group row">
    <label for="name" class="col-sm-3 col-form-label">
        <span class="text-danger">*</span>
        用戶名稱：
    </label>
    <div class="col-sm-9">
        <input id="name" name="name" class="form-control @error('name') is-invalid @enderror"
               placeholder="" value="{{ $name }}" maxlength="30">
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="email" class="col-sm-3 col-form-label">
        <span class="text-danger">*</span>
        電子信箱：
    </label>
    <div class="col-sm-9">
        <input id="email" name="email" class="form-control @error('email') is-invalid @enderror"
               placeholder="" value="{{ $email }}" maxlength="30">
        @error('email')
        <span class="invalid-feedback" role="alert">
             <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="password" class="col-sm-3 col-form-label">
        <span class="text-danger">*</span>
        密碼：
    </label>
    <div class="col-sm-9">
        <input id="password" name="password" type="password"
               class="form-control @error('password') is-invalid @enderror"
               placeholder="" value="" maxlength="30">
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="password_confirmation" class="col-sm-3 col-form-label">
        <span class="text-danger">*</span>
        確認密碼：
    </label>
    <div class="col-sm-9">
        <input id="password_confirmation" name="password_confirmation" type="password"
               class="form-control @error('password_confirmation') is-invalid @enderror"
               placeholder="" value="" maxlength="30">
        @error('password_confirmation')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
