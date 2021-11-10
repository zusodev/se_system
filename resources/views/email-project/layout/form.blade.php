@csrf
<h5>專案基本資料</h5>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">
                <span class="text-danger">*</span>
                專案名稱
            </label>
            <div class="col-sm-9">
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
    </div>
    <div class="col-sm-6">
        <div class="form-group row">
            <label for="sender_name" class="col-sm-3 col-form-label">
                專案描述
            </label>
            <div class="col-sm-9">
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description" name="description"
                          rows="3" maxlength="300">{{ $description }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>
<h5>寄送設定</h5>
<p>寄送設定請遵循以下規範，否則寄信將可能被 SMTP Server 阻擋而導致目標人員無法收到信件。</p>
<ul>
    <li>寄件者信箱請用合法的域名，例：test@zuso.ai</li>
    <li>寄件者名稱請勿使用 <span class="badge badge-danger badge-pill" style="font-size: 14px">test</span> </li>
</ul>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group row">
            <label for="sender_name" class="col-sm-3 col-form-label">
                <span class="text-danger">*</span>
                寄件者名稱
            </label>
            <div class="col-sm-9">
                <input id="sender_name" name="sender_name"
                       class="form-control @error('sender_name') is-invalid @enderror"
                       placeholder="" value="{{ $sender_name }}"
                       maxlength="50" required>
                @error('sender_name')

                <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group row">
            <label for="sender_email" class="col-sm-3 col-form-label">
                <span class="text-danger">*</span>
                寄件者信箱
            </label>
            <div class="col-sm-9">
                <input id="sender_email" name="sender_email"
                       type="email"
                       class="form-control @error('sender_email') is-invalid @enderror"
                       placeholder="" value="{{ $sender_email }}"
                       maxlength="50" required>
                @error('sender_email')

                <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>


@php
    /** @var App\Models\EmailTemplate[] $emailTemplates
     * @var App\Models\PhishingWebsite[] $phishingWebsites
    */
@endphp
<div class="row">
    <div class="col-sm-6">
        <div class="form-group row">
            <label for="email_template_id" class="col-sm-3 col-form-label">
                <span class="text-danger">*</span>
                信件樣式
            </label>
            <div class="col-sm-9">
                <select id="email_template_id" name="email_template_id"
                        class="form-control @error('email_template_id') is-invalid @enderror">
                    @if($emailTemplates->count() == 0)
                        <option value="0">At least create one template</option>
                    @endif
                    @foreach($emailTemplates as $emailTemplate)
                        <option value="{{ $emailTemplate->id }}"
                                @if(old("email_template_id") == $emailTemplate->id) selected @endif>
                            {{ $emailTemplate->name }}
                        </option>
                    @endforeach
                </select>
                @error('email_template_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <label for="phishing_website_id" class="col-sm-3 col-form-label">
                釣魚網站樣式
            </label>
            <div class="col-sm-9">
                <select id="phishing_website_id" name="phishing_website_id"
                        class="form-control @error('phishing_website_id') is-invalid @enderror">
                    <option value="">無</option>
                    @foreach($phishingWebsites as $website)
                        <option value="{{ $website->id }}"
                                @if(old("phishing_website_id") == $website->id) selected @endif>
                            {{ $website->name }}
                        </option>
                    @endforeach
                </select>
                @error('phishing_website_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <label for="log_redirect_to" class="col-sm-3 col-form-label">
                <span class="text-danger">*</span>
                自動導向頁面
            </label>
            <div class="col-sm-9">
                <input id="log_redirect_to" name="log_redirect_to"
                       type="url"
                       class="form-control @error('log_redirect_to') is-invalid @enderror"
                       placeholder="http://www.google.com/" value="{{ $log_redirect_to }}"
                       maxlength="50" required>
                @error('log_redirect_to')

                <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>
<h5>寄送目標</h5>
<div class="row">
    <div class="col-md-6">
        <div class="form-group row">
            <label for="company_id" class="col-sm-3 col-form-label">
                <span class="text-danger">*</span>
                目標公司
            </label>
            <div class="col-sm-9">
                <select id="company_id" name="company_id"
                        class="form-control" @change="selectCompany($event)"
                        required>
                    <?php /* @var App\Models\TargetCompany[] $companies */?>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" @if(!$loop->index) selected @endif>
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
    </div>
    <div class="col-md-12" v-show="selectedCompanyId">
        <div class="form-group row">
            <label for="department_ids" class="col-sm-3 col-form-label">
                <span class="text-danger">*</span>
                部門：
            </label>
            <div class="col-sm-9">
                <select id="department_ids" name="department_ids[]"
                        class="form-control" multiple required>
                    <option v-if="deparmentsOptions.length" value="all">
                        全選
                    </option>
                    <option v-for="item in deparmentsOptions" v-bind:value="item.id"
                            :selected="selectedDepartments.includes(item.id)">
                        @{{ item.name }}
                    </option>
                    <option v-if="!deparmentsOptions.length" value="">
                        此公司尚無部門，請
                    </option>

                </select>
            </div>
        </div>
    </div>
</div>

<h5>執行時間</h5>
<div class="row">
    <div class="col-md-6">
        <div class="form-group row">
            <label for="start_at" class="col-sm-3 col-form-label">* 執行發信日期 </label>
            <div class="col-sm-9">
                <input id="start_at" name="start_at" type="datetime-local"
                       class="form-control @error('start_at') is-invalid @enderror"
                       min="{{ now()->format("Y-m-d\TH:i") }}"
                       placeholder="" value="{{ $start_at }}">
                @error('start_at')
                <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
                @enderror
            </div>
        </div>
    </div>
</div>
