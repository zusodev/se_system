@extends('layouts.base')
@section('content')
    <div class="row">
        <div class="offset-md-2 col-md-8 col-sm-12">
            <h3> 新增目標公司 </h3>

            <div class="card">
                <div class="card-body">
                    @include("layouts.result")

                    <form method="post" action="{{ route("target_companys.store") }}">
                        @include("target-company.layout.form",[
                            "name" => old("name"),
                        ])
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">新增</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
