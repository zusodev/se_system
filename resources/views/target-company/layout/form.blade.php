@csrf
<div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label">
        <span class="text-danger">*</span>
        公司名稱
    </label>
    <div class="col-sm-8">
        <input id="name" name="name"
               class="form-control @error('name') is-invalid @enderror"
               placeholder="" value="{{ $name }}"
               maxlength="50" required>
        @error('name')

        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
