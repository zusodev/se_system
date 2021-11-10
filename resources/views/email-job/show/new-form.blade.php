@csrf
<h5>專案基本資料</h5>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">
                專案名稱
            </label>
            <div class="col-sm-9">
                <input id="name" name="name"
                       class="form-control "
                       placeholder="" value="{{ $name }}"
                       maxlength="50" required>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group row">
            <label for="sender_name" class="col-sm-3 col-form-label">
                專案描述
            </label>
            <div class="col-sm-9">
                <textarea class="form-control"
                          id="description" name="description"
                          rows="3" maxlength="300">{{ $description }}</textarea>
            </div>
        </div>
    </div>
</div>
<h5>寄送設定</h5>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group row">
            <label for="sender_name" class="col-sm-3 col-form-label">
                寄件者名稱
            </label>
            <div class="col-sm-9">
                <input id="sender_name" name="sender_name"
                       class="form-control"
                       value="{{ $sender_name }}"
                       maxlength="50" required>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group row">
            <label for="sender_email" class="col-sm-3 col-form-label">
                寄件者信箱
            </label>
            <div class="col-sm-9">
                <input id="sender_email" name="sender_email"
                       type="email"
                       class="form-control"
                       value="{{ $sender_email }}"
                       maxlength="50" required>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group row">
            <label for="email_tempalte_name" class="col-sm-3 col-form-label">
                信件樣式
            </label>
            <div class="col-sm-9">
                <input id="email_tempalte_name" name="email_tempalte_name"
                       type="text"
                       class="form-control" value="{{ $email_tempalte_name }}"
                       maxlength="50" required>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <label for="website_name" class="col-sm-3 col-form-label">
                網站樣式
            </label>
            <div class="col-sm-9">
                <input id="website_name" name="website_name"
                       type="text"
                       class="form-control" value="{{ $website_name }}"
                       maxlength="50" required>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <label for="log_redirect_to" class="col-sm-3 col-form-label">
                自動導向頁面
            </label>
            <div class="col-sm-9">
                <input id="log_redirect_to" name="log_redirect_to"
                       type="url"
                       class="form-control "
                       value="{{ $log_redirect_to }}"
                       maxlength="50" required>
            </div>
        </div>
    </div>
</div>
<h5>執行時間</h5>
<div class="row">
    <div class="col-md-6">
        <div class="form-group row">
            <label for="start_at" class="col-sm-3 col-form-label">執行發信日期 </label>
            <div class="col-sm-9">
                <input id="start_at" name="start_at" type="datetime-local"
                       class="form-control "
                       placeholder="" value="{{ $start_at }}">
            </div>
        </div>
    </div>
</div>
