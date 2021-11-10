@csrf
<div class="row">
    <div class="col-lg-6 col-md-8 col-sm-12">
        <div class="form-group row">
            <label for="name" class="col-sm-4">* 樣式名稱</label>
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
</div>
<hr>
<h5>網站樣式 HTML </h5>
<ul>
    <li>可在內容放置 <code>form</code> HTML Tag，SE 系統將自動修改表單傳輸位置，收集目標者傳輸資料</li>
    <li>每一次修改之後，可在 <strong>釣魚網站樣式列表</strong> 當中驗證其表單接收功能是否正常</li>
</ul>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <textarea class="form-control" id="template" name="template" rows="10">{!! $template !!}</textarea>
        </div>
    </div>
</div>
