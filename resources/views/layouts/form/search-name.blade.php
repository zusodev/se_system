<form>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="name" class="col-form-label">名稱</label>
                </div>
                <div class="col-sm-8">
                    <input id="name" name="name"
                           class="form-control"
                           value="{{ request("name") }}"
                           maxlength="10">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">搜尋</button>
        </div>
    </div>
    @isset($company)
    <input name="company_id"  class="d-none" value="{{ $company ? $company->id : '' }}">
    @endisset
    @isset($department)
    <input name="department_id"  class="d-none" value="{{ $department ? $department->id : '' }}">
    @endisset

    @isset($project)
        <input name="project_id"  class="d-none" value="{{ $project ? $project->id : '' }}">
    @endisset
</form>
