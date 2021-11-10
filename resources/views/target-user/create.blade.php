@extends('layouts.base')
@section('content')
    @php $companyId = old("company_id") ?? request("company_id");
    /** @var int[] $companyIds */
    $comapnyIsExists = in_array($companyId, $companyIds)
    @endphp
    <div class="row">
        <div class="offset-md-2 col-md-8 col-sm-12">
            <h3> 新增目標人員 </h3>

            <div class="card">
                <div class="card-body">
                    @include("layouts.result")

                    <form method="post" action="{{ route("target_users.store") }}">
                        @include("target-user.layout.form",[
                            "name" => old("name"),
                            "email" => old("email"),

                            "companies" => $companies,
                            "comapnyIsExists" => $comapnyIsExists,
                            "companyId" => $companyId,
                        ])
                        <div class="form-group row" v-if="!departmentsIsEmpty">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">新增</button>
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
                selectedDepartmentId: `{{ old("department_id") }}`,
                deparmentsMap: JSON.parse(`@json($deparmentsMap)`),
                deparmentsOptions: [],
                selectedDepartments: [],

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

