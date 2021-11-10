@extends('layouts.base')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include("layouts.result")
        </div>
    </div>
    <form method="post" action="{{ route("emailJobs.store") }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @include("email-job.create.form")
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @include("email-job.create.scheduleForm")
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">新增</button>
            </div>
        </div>
    </form>
@endsection
@section("javascript")
    <script src="{{ asset("js/datetimepicker.min.js") }}" type="text/javascript"></script>
    <link href="{{ asset("css/datetimepicker.min.css") }}" rel="stylesheet" type="text/css" />
    <script>
        /*$('#start').datetimepicker({
            uiLibrary: 'bootstrap4',
            modal: true,
            footer: true
        });;*/
    </script>
@endsection
