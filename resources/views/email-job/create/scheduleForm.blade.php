<p>注意，寄件者名稱 禁止輸入 <span class="text-danger">test</span>(使用 Gmail Server 會導致發信失敗)</p>
<div class="form-group row">
    <label for="sender_name" class="col-sm-4">* 寄件者名稱</label>
    <div class="col-sm-8">
        <input id="sender_name" name="sender_name"
               class="form-control @error('sender_name') is-invalid @enderror"
               placeholder="" value="{{ old("sender_name") }}"
               maxlength="50">
        @error('sender_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<div class="form-group row">
    <label for="sender_email" class="col-sm-4">* 寄件者信箱</label>
    <div class="col-sm-8">
        <input id="sender_email" name="sender_email"
               class="form-control @error('sender_email') is-invalid @enderror"
               placeholder="" value="{{ old("sender_email") }}"
               maxlength="50">
        @error('sender_email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

</div>
<?php $now = (now())->subMinutes(1);?>
<div class="form-group row">
    <label for="start_date" class="col-sm-4">* 排程啟動發信日期 </label>
    <div class="col-sm-8">
        <input id="start_date" name="start_date" type="date"
               class="form-control @error('start_date') is-invalid @enderror"
               placeholder="" value="{{ old("start_date") ? old("start_date") : $now->format("Y-m-d") }}">
        @error('start_date')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="start_time" class="col-sm-4">* 排程啟動發信時間 </label>
    <div class="col-sm-8">
        <input id="start_time" name="start_time" type="text"
               class="form-control @error('start_time') is-invalid @enderror"
               placeholder="10:00" value="{{ old("start_time") ? old("start_time") : $now->format("H:i") }}" maxlength="5">
        @error('start_time')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
