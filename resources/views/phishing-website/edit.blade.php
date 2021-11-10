@php /** @var App\Models\PhishingWebsite $website */ @endphp
@extends('layouts.base')
@section('content')
    @php
        $template = old("template") ?? $website->template;
    @endphp
    <div class="row">
        <div class="col-md-12">
            @include("layouts.result")
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5> 修改釣魚網站 </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route("phishing_websites.update",[$website->id]) }}">
                        @method("PUT")
                        @include("phishing-website.layout.form",[
                            "name" => old("name") ?? $website->name,
                        ])
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">儲存</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("javascript")
    <script>
       /* CKEDITOR.replace('template', {
            // filebrowserUploadUrl: 'ckeditor/ck_upload.php',
            filebrowserImageUploadUrl: ``,
            // filebrowserUploadMethod: 'form',
            fileTools_requestHeaders: {
                ['X-CSRF-TOKEN']: `{{ csrf_token() }}`
            },
            // startupMode:'source'
        });*/
        // CKEDITOR.instances.template.setData(decodeHtmlspecialChars(``));
    </script>
@endsection
