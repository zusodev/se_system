<?php /* @var App\Models\EmailJob $emailJob */ ?>
<div class="form-group row">
    <label for="name" class="col-sm-4">* 專案名稱</label>
    <div class="col-sm-8">
        <input id="name" name="name"
               class="form-control" value="{{ $emailJob->project_name }}"
               maxlength="50" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="description" class="col-sm-4">描述</label>
    <div class="col-sm-8">
        <textarea class="form-control"
                  id="description" rows="3" maxlength="50" disabled>{{ $emailJob->project_description }}</textarea>
    </div>

</div>
<div class="form-group row">
    <label for="template_name" class="col-sm-4">信件樣式</label>
    <div class="col-sm-8">
        <input id="template_name" name="template_name" class="form-control"
               value="{{ $emailJob->template_name }}" disabled>
    </div>
</div>

<div class="form-group row">
    <label for="group" class="col-sm-4">* 部門</label>
    <div class="col-sm-8">
        <input id="group" name="group"
               class="form-control" value="{{ $emailJob->department_name }}"
               maxlength="50" disabled>
    </div>
</div>

