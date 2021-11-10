@php /** @var App\Models\PhishingWebsite $website */ @endphp
@extends('layouts.base')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include("layouts.result")
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5>成功取得 <span class="badge badge-pill badge-primary" style="font-size: 1rem">
                            {{ $website->name }}
                        </span> 釣魚網站樣式的表單提交資料
                    </h5>
                    <hr>
                    <pre class="d-block p-2 bg-dark text-white" style="
                font-size: 15px;
                white-space: pre-wrap;       /* Since CSS 2.1 */
                white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
                white-space: -pre-wrap;      /* Opera 4-6 */
                white-space: -o-pre-wrap;    /* Opera 7 */
                word-wrap: break-word;       /* Internet Explorer 5.5+ */
                ">@json($postJson, JSON_PRETTY_PRINT)</pre>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("javascript")
    <script>


    </script>
@endsection
