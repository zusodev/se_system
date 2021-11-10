<?php    /** @var App\Models\TargetUser $user */ ?>
@extends('layouts.base')

@section('content')
    @php $companyId = $user->targetDepartment->company_id;
    /** @var int[] $companyIds */
    $comapnyIsExists = in_array($companyId, $companyIds)
    @endphp
    <div class="row">
        <div class="col-md-12">
            @include("layouts.result")
        </div>
    </div>

    <div class="row">
        <div class="offset-md-2 col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5> 修改目標人員 </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route("target_users.update", [$user->id]) }}">
                        @method("PUT")
                        @include("target-user.layout.form",[
                            "name" => old("name") ?? $user->name,
                            "email" => old("email") ?? $user->email,
                            "companies" => $companies,
                            "comapnyIsExists" => $comapnyIsExists,
                            "companyId" => $companyId,

                            "disabledCompany" => true
                        ])
                        <div class="form-group row" v-if="!departmentsIsEmpty">
                            <div class="col-sm-12">
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
    <script src="{{ asset("js/vue.min.js") }}"></script>
    <script>
        new Vue({
            el: "#layout-content",
            data: {
                selectedCompanyId: `{{ $companyId }}`,
                selectedDepartmentId: `{{ old("department_id") ?? $user->department_id }}`,
                deparmentsMap: JSON.parse(`@json($deparmentsMap)`),
                deparmentsOptions: [],


                selectedCompanyIdIsValid: !!`{{ $comapnyIsExists ? "" : "" }}`,
                departmentsIsEmpty: true,
            },
            methods: {
                selectCompany() {
                    this.selectedCompanyId = document.getElementById('company_id').value;
                    this.setDepartmentsOptionsAndShowForm();
                },
                setDepartmentsOptionsAndShowForm() {
                    const selectedDepartments = this.deparmentsMap[this.selectedCompanyId];

                    this.selectedCompanyIdIsValid = !!(selectedDepartments);
                    if (!R.is(Array, selectedDepartments)) {
                        this.deparmentsOptions = [];
                        this.departmentsIsEmpty = true;
                        return;
                    }

                    this.deparmentsOptions = selectedDepartments;
                    this.departmentsIsEmpty = !(selectedDepartments.length);
                }
            },
            mounted() {
                this.setDepartmentsOptionsAndShowForm();
            }
        })
    </script>
@endsection
