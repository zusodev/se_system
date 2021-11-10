@csrf
<div class="row">
    <div class="col-lg-6 col-md-8 col-sm-12">
        <div class="form-group row">
            <label for="name" class="col-sm-4 col-form-label">
                <span class="text-danger">*</span>
                樣式名稱
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
    </div>
    <div class="col-lg-6 col-md-8 col-sm-12">
        <div class="form-group row">
            <label for="subject" class="col-sm-4 col-form-label">
                <span class="text-danger">*</span>寄件主旨
            </label>
            <div class="col-sm-8">
                <input id="subject" name="subject"
                       class="form-control @error('subject') is-invalid @enderror"
                       value="{{ $subject }}" maxlength="50" required>
                @error('subject')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>
<h4>信件內容 </h4>
<p>在信件內容中，使用以下特殊字元，系統將自動替換成對應的資料。</p>
<ul style="font-size: 16px;">
    <li>
        <span class="badge badge-primary m-1" style="font-size: 16px;">@name@</span>
        ：使用者姓名
    </li>
    <li>
        <span class="badge badge-primary m-1" style="font-size: 16px;">@email@</span>
        ：使用者信箱
    </li>
    <li>
        <span class="badge badge-primary m-1" style="font-size: 16px;">@password@</span>
        ：產生亂數密碼
    </li>
    <li>
        <span class="badge badge-primary m-1" style="font-size: 16px;">@embedded_link@</span>
        ：釣魚網址
    </li>
</ul>

<h4>其他</h4>
<ul>
    <li>可使用圖片拖曳上傳，圖片大小限定 1 MB</li>
</ul>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <textarea class="form-control" id="template" name="template" rows="10"></textarea>
        </div>
    </div>
</div>
<input id="is_delete_attachment" name="is_delete_attachment" value="" style="display: none;" disabled>
<hr>
<div class="form-group row">
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <label for="subject" class="col-sm-4 col-form-label">
                附件上傳
            </label>
            <div class="col-sm-8">
                <input id="attachment" name="attachment" type="file"
                       class="file-upload-default  ">
                <div class="input-group col-xs-12">
                    <input id="attachment_info" type="text" class="form-control file-upload-info" disabled
                           value="{{ $attachment_name }}">
                    <span class="input-group-append">
                        <button type="button"
                                class="file-upload-browse btn btn-primary">
                        瀏覽
                        </button>
                    </span>
                </div>
                @error('attachment')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-6">
        @if($attachment_name)
            <a class="btn btn-primary btn-sm"
               href="{{ route("email_templates.show.attachment", [$id]) }}">
                下載附件
            </a>
            <button type="button" class="btn btn-danger btn-sm"
                    onclick="clearAttachmentInfo()">
                刪除附件
            </button>
        @endif
    </div>
</div>

<ul style="font-size: 16px;">
    <li class="m-2">
        附件檔案的原始碼當中，
        <span class="badge badge-pill badge-primary m-1" style="font-size: 16px;">http://target_url</span> 以及
        <span class="badge badge-pill badge-primary m-1" style="font-size: 16px;">target_url</span>
        字元將自動被替換成 Log 收集的網址。
    </li>
    <li class="m-2">建議下載下方的附件範本
        <ul>
            <li class="m-3">
                注意，VBS 易被 Mail Server 視為惡意附件檔案，而阻擋信件
            </li>
            <li class="m-3">
                ps1 檔案必須使用 PowerShell 執行才能收到 log
            </li>
        </ul>
    </li>
</ul>
<div class="row">
    <div class="col-md-12">
        <?php
            $colors = ["facebook", "youtube", "twitter", "dribbble", "linkedin", "google"];
        ?>
        @foreach($attachmentTemplates as $text => $content)
            <button type="button" class="m-2 btn btn-outline-{{ $colors[($loop->index % 5)] }}"
                    onclick="location.href=`{{ route("email_templates.default.attachment",[$content["file_name"]]) }}`">
                {{ $text }}
            </button>
        @endforeach
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <button type="button" class="m-2 btn btn-outline-youtube"
                onclick="openSetExeAttathmentModal()">
            設置 exe 附件
        </button>
    </div>
</div>
<hr>
