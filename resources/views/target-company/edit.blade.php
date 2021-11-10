@php
    /** @var App\Models\TargetCompany $company */
@endphp
@extends('layouts.base')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include("layouts.result")
        </div>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5> 修改目標公司 </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route("target_companys.update", [$company->id]) }}">
                        @method("PUT")
                        @include("target-company.layout.form",[
                            "name" => old("name") ?? $company->name,
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
