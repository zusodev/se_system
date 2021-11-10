@php /** @var App\Models\TargetCompany $company  */ @endphp
@extends('layouts.base')
@section('content')
    <h3> 名單上傳(目標人員) </h3>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @include("layouts.result")
                </div>
            </div>
            @component("target-company.layout.belong-header", ["company" => $company])
                <a href="{{ route("target_users.example.csv") }}">CSV 範例格式下載</a>
            @endcomponent

            <ul>
                <li>
                    CSV 上傳會自動建立 <strong>部門</strong> 以及 <strong>人員</strong>
                </li>
                <li>
                    倘若此人員的 Email 已存在，則會自動取代不寫入
                </li>
            </ul>
            <form method="post" action="{{ route("target_users.upload.store",[$company->id]) }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="users_file">上傳 CSV </label>
                        <input id="users_file" name="users_file" type="file"
                               class="file-upload-default  ">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled
                                   placeholder="上傳檔案">
                            <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">瀏覽</button>
                        </span>
                        </div>
                        @error('users_file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">送出</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">取消</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <br>
    <div class="card">
        <div class="card-body">
            <h5> 目標人員上傳失敗紀錄 </h5>
            @include("upload-failed-target-user.index.table")
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset("js/vue.min.js") }}"></script>
@endsection
