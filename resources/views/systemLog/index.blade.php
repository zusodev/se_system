@extends('layouts.base')

@section('content')
    <h3> Log File </h3>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                @include("systemLog.index.table")
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <h3>檔案名稱：{{ $fileName ?: "無" }}</h3>
            <div>
                <pre class="d-block p-2 bg-dark text-white pre-json">{{ $fileContent }}</pre>
            </div>
        </div>
    </div>
    <br>
@endsection
