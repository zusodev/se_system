@csrf
<div class="form-group row">
    <label for="company_id" class="col-sm-3 col-form-label">目標公司：</label>
    <div class="col-sm-9">
        <select id="company_id" name="company_id"
                class="form-control" @change="selectCompany($event)"
        @isset($disabledCompany) disabled @endif>
            <option @if(!$comapnyIsExists) selected @endif>請選擇</option>
            <?php /* @var App\Models\TargetCompany[] $companies */ ?>
            @foreach($companies as $company)
                <option value="{{ $company->id }}"
                        @if($companyId == $company->id) selected @endif>{{ $company->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row" v-show="selectedCompanyIdIsValid">
    <label for="department_id" class="col-sm-3 col-form-label">部門：</label>
    <div class="col-sm-9">
        <select id="department_id" name="department_id"
                class="form-control"
        v-model="selectedDepartmentId">
            <option v-for="item in deparmentsOptions" v-bind:value="item.id">
                @{{ item.name }}
            </option>
            <option v-if="departmentsIsEmpty" value="">
                此公司尚無部門，請先新建部門
            </option>
        </select>
    </div>
</div>

<div v-show="!departmentsIsEmpty">
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">名稱：</label>
        <div class="col-sm-9">
            <input id="name" name="name" class="form-control
               @error('name') is-invalid @enderror" placeholder=""
                   value="{{ $name }}">
            @error('name')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label">電子信箱：</label>
        <div class="col-sm-9">
            <input id="email" name="email" class="form-control
            @error('email') is-invalid @enderror"
                   placeholder="" value="{{ $email }}">
            @error('email')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
    </div>
</div>



