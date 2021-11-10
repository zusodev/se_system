@extends('layouts.base')
@section('content')
    <h3> 目標人員上傳失敗紀錄 </h3>
    <div class="card">
        <div class="card-body">
            @include("layouts.result")
            @include("upload-failed-target-user.index.table")
        </div>
    </div>
@endsection
