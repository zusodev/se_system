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
                    <h5> 修改部門 </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route("target_departments.update", [$department->id]) }}">
                        @csrf
                        @method("PUT")
                        @php
                            /** @var App\Models\TargetDepartment $department */
                        @endphp
                        @include("target-department.layout.form",[
                            "name" => old("name") ?? $department->name,
                            "companies" => $companies,
                            "companyId" => old("company_id") ?? $department->company_id,
                            "disabledComapny" => true,
                            'is_test' => old('is_test') ?? $department->is_test
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
