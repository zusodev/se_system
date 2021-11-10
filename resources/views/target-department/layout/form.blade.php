<div class="form-group row">
    <label for="company_id" class="col-sm-4 col-form-label">所屬公司：</label>
    <div class="col-sm-8">
        <select class="form-control" id="company_id" name="company_id"
                @isset($disabledComapny) disabled @endisset >
            <?php /* @var App\Models\TargetCompany[] $companies */?>
            @foreach($companies as $company)
                <option value="{{ $company->id }}" @if($company->id == $companyId) selected @endif>
                    {{ $company->name }}
                </option>
            @endforeach
        </select>
        @error('company_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-sm-4">部門名稱</label>
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

<div class="form-check form-check-flat form-check-primary">
    <label class="form-check-label">
        <input id="is_test" name="is_test"
               type="checkbox" class="form-check-input"
               value="true"
               @if($is_test) checked @endif >
        測試部門
        <i class="input-helper"></i></label>
</div>
<ul>
    <li>若勾選測試部門，則在首頁與報表的資料統計時，測試部門將不納入統計</li>
</ul>
