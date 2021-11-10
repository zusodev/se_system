<?php /* @var App\Models\EmailJob $emailJob */ ?>
<div class="form-group row">
    <label for="sender_name" class="col-sm-4">* 寄件者名稱 </label>
    <div class="col-sm-8">
        <input id="sender_name" name="sender_name"
               class="form-control" placeholder="" value="{{ $emailJob->project_sender_name }}"
               maxlength="50" disabled>
    </div>

</div>
<div class="form-group row">
    <label for="sender_email" class="col-sm-4">* 寄件者信箱</label>
    <div class="col-sm-8">
        <input id="sender_email" name="sender_email"
               class="form-control"
               placeholder="" value="{{ $emailJob->project_sender_email }}"
               maxlength="50" disabled>
    </div>

</div>
<div class="form-group row">
    <label for="start_at" class="col-sm-4">* 排程啟動發信日期</label>
    <div class="col-sm-8">
        <input id="start_at" name="start_at" type="datetime-local"
               class="form-control"
               value="{{ $emailJob->project_start_at }}"
               disabled>
    </div>
</div>

